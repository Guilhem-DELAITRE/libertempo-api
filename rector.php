<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/Absence',
        __DIR__ . '/Configuration',
        __DIR__ . '/Edition',
        __DIR__ . '/Fermeture',
        __DIR__ . '/Groupe',
        __DIR__ . '/Heure',
        __DIR__ . '/JourFerie',
        __DIR__ . '/Journal',
        __DIR__ . '/Mail',
        __DIR__ . '/Planning',
        __DIR__ . '/Public',
        __DIR__ . '/Solde',
        __DIR__ . '/Tests',
        __DIR__ . '/Tools',
        __DIR__ . '/Utilisateur',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0)
    ->withSets([\Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_83]);
