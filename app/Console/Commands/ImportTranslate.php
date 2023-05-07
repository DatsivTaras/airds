<?php

namespace App\Console\Commands;

use App\Components\ImportCiti;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Country;
use Illuminate\Support\Facades\File;

use Illuminate\Console\Command;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\Config;
use Spatie\TranslationLoader\LanguageLine;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ImportTranslate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:translate';

    protected $description = 'bd translate';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
       $this->fileToTranslateDb();
    //    $this->CoyntryToTranslateDb();
    // $this->CitiToTranslateDb();

    }
        public function CitiToTranslateDb() {
            $cities = Cities::all();
            foreach(Config::get('languages') as $key => $lang) {
                $tr = new GoogleTranslate($key);
                foreach ($cities as $citi) {
                    $query = LanguageLine::where("key", mb_strtolower($citi->name))->first();
                    if ($query) {
                        $query->setTranslation($key, $tr->translate($citi->name));
                        $query->save();
                    } else {
                        LanguageLine::create([
                            'group' => 'citi',
                            'key' => mb_strtolower($citi->name),
                            'text' => [$key => $tr->translate($citi->name)],
                        ]);
                    }
                }
            }
        }
        public function CoyntryToTranslateDb() {
            $countries = Countries::all();
            foreach(Config::get('languages') as $key => $lang) {
                $tr = new GoogleTranslate($key);
                foreach ($countries as $country) {
                    $query = LanguageLine::where("key", $country->name)->first();
                    if ($query) {
                        $query->setTranslation($key, $tr->translate($country->name));
                        $query->save();
                    } else {
                        LanguageLine::create([
                            'group' => 'country',
                            'key' => mb_strtolower($country->name),
                            'text' => [$key => $tr->translate($country->name)],
                        ]);
                    }
                }
            }
        }
        public function fileToTranslateDb() {
        $allFile = File::allFiles(public_path().'/../resources/lang');
        foreach ($allFile as $file) {
            $filePatch = $file->getPathname();
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $fileName =  $file->getFilenameWithoutExtension() ;
            $relativePath = $file->getRelativePath();

            foreach (include($filePatch) as $key => $value) {
                $g = $this->generateValues($key, $value);
                foreach ($g as $key => $content) {
                    $query = LanguageLine::where("key", $key)->first();
                    if ($query){

                        $query->setTranslation($relativePath, $content);
                        $query->save();

                    }else{
                    LanguageLine::create([
                        'group' => $fileName,
                        'key' => $key,
                        'text' => [$relativePath => $content],
                     ]);
                    }
                }
            }
        }
    }
    public function generateValues($key, $values) {
        if (is_array($values)) {
            $res = [];
            foreach ($values as $key2 => $value) {
                $nkey = $key.'.'.$key2;
                $res = array_merge($res, $this->generateValues($nkey, $value));
            }

            return $res;
        }

        return [$key => $values];
    }
}
