<?php

namespace App\Helpers;

class InboxHelper
{
    /**
     * Mapping route button di tabel
     */
    public static function routeForJenisSurat($jenis, $id)
    {
        $jenis = strtolower(trim($jenis));

        $routes = [
            'penawaran'     => 'admin.inboxpenawaran',
            'kontrak'       => 'admin.inboxkontrak',
            'pengiriman'    => 'admin.inboxpengiriman',
            'setuju'        => 'admin.inboxsetuju',
            'tidak setuju'  => 'admin.inboxtidaksetuju',

            // ⭐ Tambahan baru
            'sph'           => 'admin.inboxsph',
            'spphb'         => 'admin.inboxspphb',
            'spb'           => 'admin.inboxspb',
            'negosiasi'     => 'admin.inboxnegosiasi',

        ];

        if (!array_key_exists($jenis, $routes)) {
            return null;
        }

        return route($routes[$jenis], $id);
    }


    /**
     * Mapping untuk menentukan VIEW detail yang dibuka
     */
    public static function detailView($jenis)
    {
        $jenis = strtolower(trim($jenis));

        return match ($jenis) {
            'penawaran'     => 'inboxpenawaran',
            'kontrak'       => 'inboxkontrak',
            'pengiriman'    => 'inboxpengiriman',
            'setuju'        => 'inboxsetuju',
            'tidak setuju'  => 'inboxtidaksetuju',

            // ⭐ Tambahan baru
            'sph'           => 'inboxsph',
            'spphb'         => 'inboxspphb',
            'spb'           => 'inboxspb',
            'negosiasi'     => 'inboxnegosiasi',

            default          => null,
        };
    }
}
