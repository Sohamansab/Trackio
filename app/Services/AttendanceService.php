<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class AttendanceService
{
    /**
     * Shift start and end times.
     *
     * @var array
     */
    protected const SHIFTS = [
        'morning' => [
            'start_time' => '08:45:00',
            'end_time'   => '17:00:00',
        ],
        'afternoon' => [
            'start_time' => '14:00:00',
            'end_time'   => '21:00:00',
        ],
    ];

    /**
     * Grace period in minutes for check-in.
     *
     * @var int
     */
    protected const GRACE_PERIOD_MINUTES = 10;

    /**
     * Determines the attendance status based on shift, check-in, and check-out times.
     *
     * @param string      $shiftName    The name of the shift (e.g., 'morning', 'afternoon').
     * @param string|null $checkIn      The check-in timestamp (e.g., '2023-10-27 09:00:00').
     * @param string|null $checkOut     The check-out timestamp (e.g., '2023-10-27 16:45:00').
     *
     * @return array
     */
    public function determineAttendanceStatus(string $shiftName, ?string $checkIn, ?string $checkOut): array
    {
        $shiftName = strtolower($shiftName);
        $this->validateShift($shiftName);

        $shift = self::SHIFTS[$shiftName];
        $checkInTime = $checkIn ? Carbon::parse($checkIn) : null;
        $checkOutTime = $checkOut ? Carbon::parse($checkOut) : null;

        $result = [
            'check_in_status' => 'On Time',
            'minutes_late'    => 0,
            'early_checkout'  => false,
            'minutes_early'   => 0,
        ];

        // Determine Check-in Status (Late or On Time)
        if ($checkInTime) {
            $shiftDate = $checkInTime->toDateString();
            $shiftStartTime = Carbon::parse("{$shiftDate} {$shift['start_time']}");
            $lateThreshold = $shiftStartTime->copy()->addMinutes(self::GRACE_PERIOD_MINUTES);

            if ($checkInTime->isAfter($lateThreshold)) {
                $result['check_in_status'] = 'Late';
                $result['minutes_late'] = (int) $shiftStartTime->addMinutes(self::GRACE_PERIOD_MINUTES)->diffInMinutes($checkInTime);
            }
        }

        // Determine Early Checkout
        if ($checkOutTime) {
            // Assume check-out is on the same day as check-in
            $shiftDate = $checkInTime ? $checkInTime->toDateString() : $checkOutTime->toDateString();
            $shiftEndTime = Carbon::parse("{$shiftDate} {$shift['end_time']}");

            if ($checkOutTime->isBefore($shiftEndTime)) {
                $result['early_checkout'] = true;
                $result['minutes_early'] = (int) $checkOutTime->diffInMinutes($shiftEndTime);
            }
        }

        return $result;
    }

    /**
     * Validates if the provided shift name exists.
     *
     * @param string $shiftName
     * @throws InvalidArgumentException
     */
    protected function validateShift(string $shiftName): void
    {
        if (!array_key_exists($shiftName, self::SHIFTS)) {
            throw new InvalidArgumentException("Invalid shift name provided: '{$shiftName}'. Valid shifts are: " . implode(', ', array_keys(self::SHIFTS)));
        }
    }
}
