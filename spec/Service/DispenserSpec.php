<?php

namespace spec\App\Service;

use App\Exceptions\NoteUnavailableException;
use App\Service\Dispenser;
use PhpSpec\ObjectBehavior;

class DispenserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType(Dispenser::class);
    }

    function it_holds_the_available_notes()
    {
        $availableNotes = Dispenser::DEFAULT_AVAILABLE_NOTES;
        $this->beConstructedWith($availableNotes);
        $this->getAvailableNotes()->shouldBe($availableNotes);
    }

    /**
     * @throws NoteUnavailableException
     */
    function it_delivers_the_amount_requested_with_the_available_notes()
    {
        $this->withdraw(10)->shouldReturn([10]);
    }

    /**
     * @throws NoteUnavailableException
     */
    function it_delivers_only_the_lowest_number_of_possible_notes()
    {
        $this->withdraw(0)->shouldReturn([]);
        $this->withdraw(20)->shouldReturn([20]);
        $this->withdraw(30)->shouldReturn([20, 10]);
        $this->withdraw(40)->shouldReturn([20, 20]);
        $this->withdraw(50)->shouldReturn([50]);
        $this->withdraw(80)->shouldReturn([50, 20, 10]);
    }

    function it_validates_if_the_note_is_not_available()
    {
        $this->shouldThrow(NoteUnavailableException::class)->during('withdraw', [125]);
    }

    function it_check_if_the_amount_is_valid()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('withdraw', [-130]);
    }

    /**
     * @throws NoteUnavailableException
     */
    function it_returns_an_empty_set_when_the_payload_is_empty()
    {
        $this->withdraw(null)->shouldReturn([]);
        $this->withdraw(0)->shouldReturn([]);
    }
}
