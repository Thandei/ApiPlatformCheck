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

    // === LOCALE FIXTURES CONFIGURATION == //
    const LOCALES = [
        [
            "code" => "tr",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.turkish",
            "flag" => "/build/media/flags/tr.svg",
            "systemsdefault" => TRUE
        ],
        [
            "code" => "en",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.english",
            "flag" => "/build/media/flags/us.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "hn",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.hindi",
            "flag" => "/build/media/flags/in.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "es",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.espaniol",
            "flag" => "/build/media/flags/es.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "fr",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.french",
            "flag" => "/build/media/flags/fr.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "ae",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.arabic",
            "flag" => "/build/media/flags/ae.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "ch",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.chinese",
            "flag" => "/build/media/flags/ch.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "ru",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.russian",
            "flag" => "/build/media/flags/ru.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "id",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.indonesian",
            "flag" => "/build/media/flags/id.svg",
            "systemsdefault" => FALSE
        ],
        ["code" => "pt",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.portuguese",
            "flag" => "/build/media/flags/pt.svg",
            "systemsdefault" => FALSE
        ],
        [
            "code" => "de",
            "name" => self::DATABASE_TRANSLATION_PREFIX . "locales.german",
            "flag" => "/build/media/flags/de.svg",
            "systemsdefault" => FALSE
        ],


    ];

    // === GENUS FIXTURES CONFIGURATION == //
    const GENUSES = [
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.dog"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.cat"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.fish"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.rabbit"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.hamster"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.donkey"
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . "genus.bird"
        ]
    ];

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
        ],
        [
            "name" => self::DATABASE_TRANSLATION_PREFIX . 'genusattr.tail',
            "unit" => "cm"
        ]
    ];
    // === GENUS ATTRIBUTE FIXTURES CONFIGURATION == //

    // === LANDING SLIDE FIXTURES CONFIGURATION == //
    const LANDING_SLIDES = [
        [
            "content" => "Find animal lovers with similar interests",
            "tags" => "animallovers,withsimilar,interests",
            "image" => "/build/media/slides/1.svg"
        ],
        [
            "content" => "Find animal lovers with similar interests",
            "tags" => "animallovers,withsimilar,interests",
            "image" => "/build/media/slides/1.svg"
        ],
        [
            "content" => "app.database.slider.content2",
            "tags" => "app.database.slider.tags2",
            "image" => "/build/media/slides/1.svg"
        ],
        [
            "content" => "app.database.slider.content3",
            "tags" => "app.database.slider.tags3",
            "image" => "/build/media/slides/1.svg"
        ]
    ];

    // === SYSTEM LOG FIXTURES CONFIGURATION == //
    const SYSTEM_LOG_COUNT = 100;

    // === SERVICE FIXTURES CONFIGURATION == //
    const SERVICES = [
        [
            "name" => "app.database.service.health",
            "description" => "app.database.service.health.description"
        ],
        [
            "name" => "app.database.service.food",
            "description" => "app.database.service.food.description"
        ],
        [
            "name" => "app.database.service.transport",
            "description" => "app.database.service.transport.description"
        ],
        [
            "name" => "app.database.service.residence",
            "description" => "app.database.service.residence.description"
        ],
        [
            "name" => "app.database.service.walk",
            "description" => "app.database.service.walk.description"
        ],
        [
            "name" => "app.database.service.shopping",
            "description" => "app.database.service.shopping.description"
        ],
        [
            "name" => "app.database.service.social",
            "description" => "app.database.service.social.description"
        ],
        [
            "name" => "app.database.service.match",
            "description" => "app.database.service.match.description"
        ],
        [
            "name" => "app.database.service.beauty",
            "description" => "app.database.service.beauty.description"
        ]
    ];

    // === APP POLICY FIXTURES CONFIGURATION == //
    const POLICIES = [
        [
            "keyname" => "privacy",
            "name" => "app.database.policy.privacy",
            "content" => "app.database.policy.privacy.content",
        ],
        [
            "keyname" => "cookie",
            "name" => "app.database.policy.cookie",
            "content" => "app.database.policy.cookie.content",
        ],
        [
            "keyname" => "data",
            "name" => "app.database.policy.data",
            "content" => "app.database.policy.data.content",
        ]
    ];

    // === PET FIXTURES CONFIGURATION == //
    const PETS_PER_USER = 5;

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
