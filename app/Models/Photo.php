<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Photo extends Model
{
    public static function imageUpload($image, $resource, $type, $resource_tag)
{
    // URL diska (za spremanje u bazu)
    $baseUrl = rtrim(config("filesystems.disks.$type.url"), '/').'/';

    // Ako postoji stara slika, obriši ju (osim default avatara)
    $stored = (string) ($resource->$resource_tag ?? '');

    if ($stored !== '') {
        // Ako je u bazi spremljen puni URL, pretvori u relativnu putanju unutar diska
        $relativeOld = str_starts_with($stored, $baseUrl)
            ? substr($stored, strlen($baseUrl))
            : ltrim($stored, '/');

        // Nemoj dirati default avatar
        if ($relativeOld !== 'default-avatar.png') {
            if (Storage::disk($type)->exists($relativeOld)) {
                Storage::disk($type)->delete($relativeOld);

                // Pokušaj obrisati ID folder ako je prazan (npr. "123")
                $dir = dirname($relativeOld);
                if ($dir !== '.' && $dir !== '') {
                    $fullDirPath = Storage::disk($type)->path($dir);
                    if (is_dir($fullDirPath)) {
                        @rmdir($fullDirPath); // briše samo ako je folder prazan
                    }
                }
            }
        }
    }

    // Spremanje nove slike
    // Za users/meals čuvaš slike u folderu po resource ID
    if ($type === 'users' || $type === 'meals') {
        // $filename = $image->getClientOriginalName(); // ako želiš sigurnije ime, vidi napomenu ispod
       $ext = $image->getClientOriginalExtension();
$filename = Str::uuid()->toString() . ($ext ? ".{$ext}" : '');

        Storage::disk($type)->putFileAs((string) $resource->id, $image, $filename);

        // Relativni path unutar diska
        $relativeNew = $resource->id . '/' . $filename;

        // Puni URL koji spremaš u bazu (kao i do sada)
        return $baseUrl . $relativeNew;
    }

    // Ako u budućnosti dodaš druge tipove, ovdje ih obradi
    // Za sada: vrati null ili baci exception da znaš da je type nepokriven
    return null;
}

public static function imageDelete($resource, $type, $resource_tag)
{
    $baseUrl = rtrim(config('filesystems.disks.' . $type . '.url'), '/') . '/';
    $stored  = (string) $resource->$resource_tag;

    if ($stored === '' || $stored === null) return false;

    $relative = str_starts_with($stored, $baseUrl) ? substr($stored, strlen($baseUrl)) : ltrim($stored, '/');

    if ($relative === "default-avatar.png") return false;

    if (Storage::disk($type)->exists($relative)) {
        Storage::disk($type)->delete($relative);

        $dir = dirname($relative); // npr. "123"
        if ($dir !== '.' && $dir !== '') {
            $fullDirPath = Storage::disk($type)->path($dir);
            if (is_dir($fullDirPath)) {
                @rmdir($fullDirPath); // briše samo ako je prazno
            }
        }

        return true;
    }

    return false;
}

}
