<?php namespace App\Service;

use Exception;
use Github\Api\Repo;
use Github\AuthMethod;
use Github\Client;

class GithubDocumentationSyncService
{

    public function getApplicationDocumentation(string $accessToken, string $username, string $repositoryName, string|null $path = null, string|null $filenameContainsFilter = NULL): null|array
    {

        $githubRepo = $this->getGithubRepository($accessToken, $username, $repositoryName);

        if (is_array($githubRepo)) {

            $repoContents = $this->getContentsOf($accessToken, $username, $repositoryName, $path);

            foreach ($repoContents as $fileIndex => $repoContent) {
                $contentType = $repoContent["type"];
                $contentFilename = $repoContent["name"];
                if ($contentType === "file") {
                    if (str_ends_with(strtolower($contentFilename), $filenameContainsFilter) or $filenameContainsFilter === NULL) {
                        $fileFullpath = $contentFilename;
                        $repoContents[$fileIndex]["content"] = $this->downloadContentsOf($accessToken, $username, $repositoryName, $fileFullpath);
                    }
                }
                if ($contentType === "dir") {
                    $repoContents[$fileIndex]["content"] = $contentFilename;
                }
            }

            return $repoContents;

        }

        return NULL;
    }


    /**
     * @param string $accessToken
     * @param string $username
     * @param string $repositoryName
     * @return array|false|null
     */
    private function getGithubRepository(string $accessToken, string $username, string $repositoryName): array|null|false
    {
        $client = $this->getGithubClient($accessToken);

        try {

            $myRepoApi = new Repo($client);
            $repoContent = $myRepoApi->show($username, $repositoryName);

            if (is_array($repoContent)) {
                return $repoContent;
            }

        } catch (Exception) {
            return FALSE;
        }


        return NULL;
    }

    /**
     * @param string $accessToken
     * @return Client
     */
    private function getGithubClient(string $accessToken): Client
    {
        $client = new Client();
        $client->authenticate($accessToken, null, AuthMethod::ACCESS_TOKEN);
        return $client;
    }

    /**
     * @param string $accessToken
     * @param string $username
     * @param string $repositoryName
     * @param string|null $contentPath
     * @return array|string
     */
    private function getContentsOf(string $accessToken, string $username, string $repositoryName, string|null $contentPath = NULL): string|array
    {
        $myClient = $this->getGithubClient($accessToken);
        $myRepo = new Repo($myClient);
        return $myRepo->contents()->show($username, $repositoryName, $contentPath);
    }


    /**
     * @param string $accessToken
     * @param string $username
     * @param string $repositoryName
     * @param string|null $contentPath
     * @return string|null
     */
    private function downloadContentsOf(string $accessToken, string $username, string $repositoryName, string|null $contentPath = NULL): null|string
    {
        try {
            $myClient = $this->getGithubClient($accessToken);
            $myRepo = new Repo($myClient);
            return $myRepo->contents()->download($username, $repositoryName, $contentPath);
        } catch (Exception) {
            return NULL;
        }

    }

}