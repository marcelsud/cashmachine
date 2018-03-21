<?php

namespace App\Controller;

use App\Exceptions\NoteUnavailableException;
use App\Service\DispenserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CashMachineController
{
    const FIELD_AMOUNT = 'amount';
    const ERROR_MESSAGE_TEMPLATE = 'Oops, something went wrong: %s';

    /**
     * @var DispenserInterface
     */
    private $dispenser;

    /**
     * @param DispenserInterface $dispenser
     */
    public function __construct(DispenserInterface $dispenser)
    {
        $this->dispenser = $dispenser;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function withdraw(Request $request)
    {
        try {
            if (!$request->query->has(self::FIELD_AMOUNT)) {
                return new JsonResponse([]);
            }

            $notes = $this->dispenser->withdraw($request->query->get(self::FIELD_AMOUNT));

            return new JsonResponse($notes);
        } catch (NoteUnavailableException | \InvalidArgumentException $exception) {
            return new JsonResponse(
                [
                    'error' => true,
                    'message' => $exception->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => true,
                    'message' => sprintf(self::ERROR_MESSAGE_TEMPLATE, $exception->getMessage())
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
