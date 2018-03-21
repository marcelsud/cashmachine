<?php

namespace App\Service;

use App\Exceptions\NoteUnavailableException;

interface DispenserInterface
{
    /**
     * @return array
     */
    public function getAvailableNotes() : array;

    /**
     * @param int|null $amount
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws NoteUnavailableException
     */
    public function withdraw(int $amount = null) : array;
}
