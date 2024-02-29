<?php

namespace D4T\Core;

use LogicException;

/* Example
use NeverThrow\SuccessResult;
use NeverThrow\ErrorResult;

// Success
class BookShipperOkResult extends SuccessResult
{
    public function __construct(
        public string $bookingId
    ) {}
}

enum BookingErrors {
    case NO_SHIPPER_AVAILABLE;
    case OVERWEIGHT_PACKAGE;
    case INVALID_ADDRESS;
}

// Error
class BookShipperErrorResult extends ErrorResult
{
    public function __construct(
        public BookingErrors $outcome
    ) {}
}


use NeverThrow\Result;

class BookShipperResult extends Result
{
    public function getOkResult(): BookShipperOkResult
    {
        return parent::getOkResult();
    }

    public function getErrorResult(): BookShipperErrorResult
    {
        return parent::getErrorResult();
    }
}

public function createBooking(User $user, BookingOrder $order): BookShipperResult
{
    $hasAnyShipperAvailable = $this->shipperService->hasAnyShipperAvailable();
    if (!$hasAnyShipperAvailable) {
        return new BookShipperResult(
            new BookShipperErrorResult(
                BookingErrors::NO_SHIPPER_AVAILABLE
            )
        );
    }

    $isOverweight = !$this->weightService->isValid($order);
    if ($isOverweight) {
        return new BookShipperResult(
            new BookShipperErrorResult(
                BookingErrors::OVERWEIGHT_PACKAGE
            )
        );
    }

    $bookingId = $this->book($user, $order);

    return new BookShipperResult(new BookShipperOkResult($bookingId));
}

$bookingResult = $this->service->createBooking($user, $order);

if ($bookingResult->isError()) {
    $errorResult = $bookingResult->getErrorResult();

    // handle error
    return showError(match ($errorResult->outcome) {
        BookingErrors::NO_SHIPPER_AVAILABLE => 'No shipper available at the moment. Please wait',
        BookingErrors::OVERWEIGHT_PACKAGE => 'Your package is overweight',
    });
}

return showBooking($bookingResult->getOkResult()->bookingId);
*/

abstract class Result
{
    private bool $isOk;
    private SuccessResult|ErrorResult $result;

    public function __construct(SuccessResult|ErrorResult $result)
    {
        $this->isOk = $result->isOk();
        $this->result = $result;
    }

    public function isOk(): bool
    {
        return $this->isOk;
    }

    public function isError(): bool
    {
        return !$this->isOk;
    }

    /**
     * @throws LogicException
     */
    public function getOkResult(): SuccessResult
    {
        if ($this->isError()) {
            throw new LogicException('Result is not OK');
        }

        return $this->result;
    }

    /**
     * @throws LogicException
     */
    public function getErrorResult(): ErrorResult
    {
        if ($this->isOk()) {
            throw new LogicException('Result is not ERROR');
        }

        return $this->result;
    }
}
