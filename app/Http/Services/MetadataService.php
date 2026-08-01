<?php

namespace App\Http\Services;

class MetadataService
{
    public function store($model, array $metadata)
    {
        foreach ($model->metadata as $meta) {
            if (!\array_key_exists($meta->key, $metadata)) {
                $meta->delete();
            }
        }
        foreach ($metadata as $meta) {
            $model->metadata()->updateOrCreate(
                ['key' => $meta['key']],
                ['value' => $meta['value']]
            );
        }
    }
}
