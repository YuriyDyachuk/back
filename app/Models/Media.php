<?php


namespace App\Models;

use Code16\Sharp\Form\Eloquent\Uploads\SharpUploadModel;
use Code16\Sharp\Form\Fields\Utils\SharpFormFieldWithUpload;

class Media extends SharpUploadModel
{
    use SharpFormFieldWithUpload;

    public const TABLE_NAME = 'medias';

    protected $table = self::TABLE_NAME;


}
