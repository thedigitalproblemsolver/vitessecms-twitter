<?php declare(strict_types=1);

namespace VitesseCms\Twitter\Listeners\Cli;

use Phalcon\Events\Event;
use VitesseCms\Cli\DTO\MappingDTO;
use VitesseCms\Cli\Models\Mapping;

class DeployListener
{
    public function JSMapping(Event $event, MappingDTO $mappingDTO): void
    {
        $mappingDTO->iterator->add(new Mapping(
            $mappingDTO->vendorDir.'seiyria/bootstrap-slider/dist/bootstrap-slider.min.js',
            $mappingDTO->publicHtmlDir.'assets/default/js/bootstrap-slider.min.js'
        ));
        $mappingDTO->iterator->add(new Mapping(
            $mappingDTO->vendorDir.'itsjavi/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
            $mappingDTO->publicHtmlDir.'assets/default/js/bootstrap-colorpicker.min.js'
        ));
    }

    public function CssMapping(Event $event, MappingDTO $mappingDTO): void
    {
        $mappingDTO->iterator->add(new Mapping(
            $mappingDTO->vendorDir.'seiyria/bootstrap-slider/dist/css/bootstrap-slider.min.css',
            $mappingDTO->publicHtmlDir.'css/bootstrap-slider.min.css'
        ));
    }
}
