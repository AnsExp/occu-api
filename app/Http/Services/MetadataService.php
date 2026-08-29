<?php

namespace App\Http\Services;

class MetadataService
{
    public function store($model, array $metadata)
    {
        $metadataByKey = collect($metadata)->keyBy('key');

        foreach ($model->metadata as $meta) {
            if (!$metadataByKey->has($meta->key)) {
                $meta->delete();
            }
        }

        foreach ($metadataByKey as $meta) {
            $model->metadata()->updateOrCreate(
                ['key' => $meta['key']],
                ['value' => $meta['value']]
            );
        }
    }
}
