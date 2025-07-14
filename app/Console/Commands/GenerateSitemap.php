<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Génère le fichier sitemap.xml pour le site';

    public function handle()
    {
        Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/calculateur/salaire-brut'))
            ->add(Url::create('/calculateur/salaire-net'))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Le fichier sitemap.xml a été généré avec succès.');
    }
}
