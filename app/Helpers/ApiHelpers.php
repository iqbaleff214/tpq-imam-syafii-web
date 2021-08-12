<?php

namespace App\Helpers;

trait ApiHelpers
{
    protected function isPengajar($user): bool {
        if (!empty($user)) {
            return $user->peran == 'Pengajar';
        }
        return false;
    }

    protected function isSantri($user): bool {
        if (!empty($user)) {
            return $user->peran == 'Santri';
        }
        return false;
    }
}
