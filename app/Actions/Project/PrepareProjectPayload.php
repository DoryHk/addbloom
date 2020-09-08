<?php

namespace App\Actions\Project;

use Carbon\Carbon;
use Image;

class PrepareProjectPayload
{
    /**
     * Prepare payload of project and store image.
     *
     * @param array $data
     *
     * @return array
     */
    public static function execute(array $data): array
    {
        $fileName = '';
        $imageData = $data['logo'];
        $validB64 = preg_match(
            "/data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).base64,.*/",
            $imageData);
        if ($validB64 && strlen($imageData) !== 0) {
            $fileName = Carbon::now()->timestamp
                . '_'
                . uniqid()
                . '.'
                . explode(
                    '/',
                    explode(':',
                        substr($imageData, 0, strpos($imageData, ';'))
                    )[1]
                )[1];
            Image::make($data['logo'])->save(public_path('/images/') . $fileName);
        }
        $app_name = $data['app_name'];
        $developer_name = $data['developer_name'];
        $version = $data['version'];
        $about = $data['about'];
        return [
            'app_name' => $app_name,
            'developer_name' => $developer_name,
            'version' => $version,
            'about' => $about,
            'logo' => $fileName,
        ];
    }
}
