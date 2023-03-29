<?php

namespace App\DataFixtures;

use App\Controller\Admin\Helpers\DatabaseTranslationController;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;


class AppFixtures extends Fixture implements OrderedFixtureInterface
{

    // === USER FIXTURES CONFIGURATION == //
    const USERS_COUNT = 100;
    const USERS_FAKE_ROLES = ["ROLE_ADMIN", "ROLE_USER"];
    const USER_FAKE_ADMIN = "sinansahinwm@gmail.com";
    const USER_FAKE_ADMIN_PASSWORD = "321";
    const USER_FAKE_ADMIN_ACCOUNT_NAME = "System Administrator";
    const USER_FAKE_ADMIN_NICK_NAME = "system.admin";
    const USER_DONT_USE_HASH = TRUE;
    const USER_PROFILE_IMAGE_WIDTH = 500;
    const USER_PROFILE_IMAGE_HEIGHT = 500;

    // === LOCALE FIXTURES CONFIGURATION == //
    const LOCALES = [
        [
            "code" => "en",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.english",
            "flag" => "/build/media/flags/us.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "tr",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.turkish",
            "flag" => "/build/media/flags/tr.svg",
            "systemsdefault" => TRUE
        ],
        [
            "code" => "ch",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.chinese",
            "flag" => "/build/media/flags/ch.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "es",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.espaniol",
            "flag" => "/build/media/flags/es.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "de",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.german",
            "flag" => "/build/media/flags/de.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "fr",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.french",
            "flag" => "/build/media/flags/fr.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "ru",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.russian",
            "flag" => "/build/media/flags/ru.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "pt",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.portuguese",
            "flag" => "/build/media/flags/pt.svg",
            "systemsdefault" => FALSE
        ]
    ];

    // === GENUS FIXTURES CONFIGURATION == //
    const GENUSES = [
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.bear"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.camel"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.donkey"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.rabbit"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.zebra"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.dog"
        ]
    ];

    // === GENUS ATTRIBUTE FIXTURES CONFIGURATION == //
    const GENUS_ATTR = [
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . 'genusattr.weight',
            "unit" => "kg"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . 'genusattr.length',
            "unit" => "cm"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . 'genusattr.eyecolor',
            "unit" => "color"
        ]
    ];

    // === SYSTEM LOG FIXTURES CONFIGURATION == //
    const SYSTEM_LOG_COUNT = 100;

    // === GLOBAL CONFIGURATION == //
    const BOOL_RAND_NULLABLE = [NULL, TRUE, FALSE];
    const DATABASE_TRANSLATION_PREFIX = DatabaseTranslationController::TRANSLATION_PREFIX;

    public Generator $fakerFactory;

    public function __construct()
    {
        $this->fakerFactory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
