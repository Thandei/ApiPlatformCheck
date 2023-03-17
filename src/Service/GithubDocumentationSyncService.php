<?php namespace App\Service;

use Exception;
use Github\Api\Repo;
use Github\AuthMethod;
use Github\Client;

class GithubDocumentationSyncService
{

    public function getApplicationDocumentation(string $accessToken, string $username, string $repositoryName): false|null|array
    {

        $githubRepo = $this->getGithubRepository($accessToken, $username, $repositoryName);

        if (is_array($githubRepo)) {

            $repositoryContents = $this->getContentsOf($accessToken, $username, $repositoryName, );

            return $repositoryContents;
        }

        return NULL;
    }

    /**
     * @param string $accessToken
     * @param string $username
     * @param string $repositoryName
     * @return array|false|null
     */
    public function getGithubRepository(string $accessToken, string $username, string $repositoryName): array|null|false
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
     * @return array|string
     */
    private function getContentsOf(string $accessToken, string $username, string $repositoryName, string|null $contentPath = NULL): string|array
    {
        $myClient = $this->getGithubClient($accessToken);
        $myRepo = new Repo($myClient);
        return $myRepo->contents()->show($username, $repositoryName, $contentPath);
    }


}
