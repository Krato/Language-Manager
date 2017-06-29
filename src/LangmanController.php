<?php

namespace EricLagarda\LangmanGUI;

use EricLagarda\LangmanGUI\Manager;

class LangmanController
{
    /**
     * Return view for index screen.
     *
     * @return Response
     */
    public function index()
    {
        return view('vendor/langManGUI/index', [
            'translations' => app(Manager::class)->getTranslations(),
            'languages'    => array_keys(app(Manager::class)->getTranslations()),
        ]);
    }

    /**
     * Synchronize with the project files and find untranslated keys.
     *
     * @return Response
     */
    public function scan()
    {
        return response(app(Manager::class)->sync());
    }

    /**
     * Save the translations
     *
     * @return void
     */
    public function save()
    {
        app(Manager::class)->saveTranslations(request()->translations);
    }

    /**
     * Save the translations
     *
     * @return void
     */
    public function addLanguage()
    {
        app(Manager::class)->addLanguage(request()->language);
    }

    /**
     * Delete the language
     *
     * @return void
     */
    public function delete()
    {
        app(Manager::class)->deleteLanguage(request()->language);
    }
}
