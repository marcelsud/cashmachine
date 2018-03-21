<?php

namespace App\Service;

use App\Exceptions\NoteUnavailableException;

class Dispenser implements DispenserInterface
{
    const DEFAULT_AVAILABLE_NOTES = [100, 50, 20, 10];
    const EXCEPTION_MESSAGE_POSITIVE_NUMBER_REQUIRED = 'A positive amount is required';
    const EXCEPTION_MESSAGE_NOTE_UNAVAILABLE = 'The available notes are: %s';

    /**
     * @var array|int[]
     */
    private $availableNotes = [];

    /**
     * @param array $notes
     */
    public function __construct(array $notes = null)
    {
        if (is_null($notes)) {
            $notes = self::DEFAULT_AVAILABLE_NOTES;
        }

        $this->availableNotes = $notes;
    }

    /**
     * @return array
     */
    public function getAvailableNotes() : array
    {
        return $this->availableNotes;
    }

    /**
     * @inheritdoc
     */
    public function withdraw(int $amount = null) : array
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException(self::EXCEPTION_MESSAGE_POSITIVE_NUMBER_REQUIRED);
        }

        if (is_null($amount) || $amount === 0) {
            return [];
        }

        return $this->processNotesToDeliver($amount);
    }

    /**
     * @param int $amount
     *
     * @return array
     * @throws NoteUnavailableException
     */
    private function processNotesToDeliver(int $amount)
    {
        $notes = $this->getAvailableNotes();
        ksort($notes);
        $notesToDeliver = [];

        $currentNote = array_shift($notes);

        while($amount > 0) {
            if ($amount < $currentNote) {
                $currentNote = array_shift($notes);

                continue;
            }

            $notesToDeliver[] = $currentNote;
            $amount -= $currentNote;

            if (count($notes) == 0) {
                break;
            }
        }

        if ($amount > 0) {
            throw new NoteUnavailableException(sprintf(
                self::EXCEPTION_MESSAGE_NOTE_UNAVAILABLE, implode(', ', $this->getAvailableNotes())
            ));
        }

        return $notesToDeliver;
    }
}
