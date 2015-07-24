<?php namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Upload
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Upload {

    /**
     * The upload directory root path.
     *
     * @var string
     */
    const ROOT_PATH = '/uploads/';

    /**
     * Maximum upload file size in KB.
     *
     * @var int
     */
    const MAX_FILE_SIZE = 10000;

    /**
     * Resource paths.
     *
     * @var array
     */
    private static $resources = [
        'user' => [
            'profile_photo' => 'users/{{OWNER_ID}}/images/profile/'
        ],
        'company' => [
            'logo'  => 'companies/{{OWNER_ID}}/images/logo/'
        ]
    ];

    /**
     * Saves a user profile photo.
     *
     * @param  UploadedFile  $file
     * @param  int           $userId
     * @return void
     * @throws Exception
     */
    public static function saveUserProfilePhoto($file, $userId)
    {
        // Create destination directory

        $destination = self::resourcePath('user.profile_photo', $userId);

        if ( ! file_exists($destination))
        {
            mkdir($destination, 0775, TRUE);
        }

        // Generate thumbnails

        $dimensions = [
            'sm' => 48,
            'md' => 200
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, $dimension)
                ->save("{$destination}{$filename}.png");
        }

        // Remove temp file

        unlink($file->getPathName());
    }

    /**
     * Saves a company loho.
     *
     * @param  UploadedFile  $file
     * @param  int           $companyId
     * @return void
     * @throws Exception
     */
    public static function saveCompanyLogo($file, $companyId)
    {
         // Create destination directory

        $destination = self::resourcePath('company.logo', $companyId);

        if ( ! file_exists($destination))
        {
            mkdir($destination, 0775, TRUE);
        }

        // Generate thumbnails

        $dimensions = [
            'sm' => 100,
            'md' => 200,
            'lg' => 300
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            Image::make($file->getPathName())
                ->orientate()
                ->resize($dimension, NULL, function($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save("{$destination}{$filename}.png");
        }

        // Remove temp file

        unlink($file->getPathName());
    }

    /**
     * Gets the path to a resource folder.
     *
     * @see    Upload::$resources
     *
     * @param  string  $key
     * @param  int     $ownerId
     * @return string
     */
    private static function resourcePath($key, $ownerId)
    {
        $keyParts = explode('.', $key);

        $path = public_path() . self::ROOT_PATH;
        $path .= str_replace('{{OWNER_ID}}', $ownerId, self::$resources[$keyParts[0]][$keyParts[1]]);

        return $path;
    }

    /**
     * Gets the url to a resource.
     *
     * @see    Upload::$resources
     *
     * @param  string  $key
     * @param  string  $filename
     * @param  int     $ownerId
     * @return string
     */
    public static function resourceUrl($key, $filename, $ownerId)
    {
        $keyParts = explode('.', $key);

        $path = self::ROOT_PATH;
        $path .= str_replace('{{OWNER_ID}}', $ownerId, self::$resources[$keyParts[0]][$keyParts[1]]);
        $path .= $filename . '?cb=' . time();

        return url($path);
    }
}
