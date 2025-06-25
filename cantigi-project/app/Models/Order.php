<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'driver_id',
        'start_booking_date',
        'end_booking_date',
        'start_booking_time',
        'end_booking_time',
        'drop_address',
        'status',
    ];

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    // Ganti relationship customer dengan user
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function return_log()
    {
        return $this->hasOne(ReturnLog::class);
    }

    public function getAdminFeeAttribute()
    {
        return 2500;
    }

    public function getTaxAttribute()
    {
        return $this->total_price * 0.11; // 11%
    }

    public function getFinalTotalAttribute()
    {
        return $this->total_price + $this->admin_fee + $this->tax;
    }

    // Format currency for display
    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedAdminFeeAttribute()
    {
        return number_format($this->admin_fee, 0, ',', '.');
    }

    public function getFormattedTaxAttribute()
    {
        return number_format($this->tax, 0, ',', '.');
    }

    public function getFormattedFinalTotalAttribute()
    {
        return number_format($this->final_total, 0, ',', '.');
    }

    public function getDurationAttribute()
    {
        if (
            !$this->start_booking_date || !$this->end_booking_date ||
            !$this->start_booking_time || !$this->end_booking_time
        ) {
            return 'Data tidak lengkap';
        }

        try {
            // Gabungkan date dan time dengan format yang benar
            $startDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->start_booking_date . ' ' . $this->start_booking_time
            );
            $endDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->end_booking_date . ' ' . $this->end_booking_time
            );

            $diffInHours = $startDateTime->diffInHours($endDateTime);
            $diffInDays = $startDateTime->diffInDays($endDateTime);

            // Format output berdasarkan durasi
            if ($diffInHours < 24) {
                return $diffInHours . ' Jam';
            } elseif ($diffInDays == 1) {
                return '1 Hari (' . $diffInHours . ' Jam)';
            } else {
                return $diffInDays . ' Hari (' . $diffInHours . ' Jam)';
            }
        } catch (\Exception $e) {
            // Debug: Log error untuk melihat data sebenarnya
            Log::error('Duration calculation error: ' . $e->getMessage(), [
                'start_booking_date' => $this->start_booking_date,
                'end_booking_date' => $this->end_booking_date,
                'start_booking_time' => $this->start_booking_time,
                'end_booking_time' => $this->end_booking_time,
                'concatenated_start' => $this->start_booking_date . ' ' . $this->start_booking_time,
                'concatenated_end' => $this->end_booking_date . ' ' . $this->end_booking_time
            ]);

            return 'Error menghitung durasi';
        }
    }

    // Accessor untuk mendapatkan durasi dalam jam
    public function getDurationInHoursAttribute()
    {
        if (!$this->start_booking_date || !$this->end_booking_date) {
            return 0;
        }

        $startDateTime = Carbon::parse($this->start_booking_date . ' ' . $this->start_booking_time);
        $endDateTime = Carbon::parse($this->end_booking_date . ' ' . $this->end_booking_time);

        return $startDateTime->diffInHours($endDateTime);
    }

    // Accessor untuk mendapatkan durasi dalam hari
    public function getDurationInDaysAttribute()
    {
        if (!$this->start_booking_date || !$this->end_booking_date) {
            return 0;
        }

        $startDateTime = Carbon::parse($this->start_booking_date . ' ' . $this->start_booking_time);
        $endDateTime = Carbon::parse($this->end_booking_date . ' ' . $this->end_booking_time);

        return $startDateTime->diffInDays($endDateTime);
    }

    public function getTotalPriceAttribute()
    {
        if (!$this->vehicle_id || !$this->duration_in_days) {
            return 0;
        }

        $vehicle = Vehicle::find($this->vehicle_id);
        return $vehicle->price_per_day * $this->duration_in_days;
    }

    public function getRentalDurationLeftAttribute()
    {
        // Check if required fields are present
        if (
            !$this->start_booking_date || !$this->end_booking_date ||
            !$this->start_booking_time || !$this->end_booking_time
        ) {
            return 'Data tidak lengkap';
        }

        try {
            // Create start and end datetime objects
            $startDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->start_booking_date . ' ' . $this->start_booking_time
            );
            $endDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->end_booking_date . ' ' . $this->end_booking_time
            );

            $now = Carbon::now();

            // If rental hasn't started yet
            if ($now->lt($startDateTime)) {
                return 'Rental belum dimulai';
            }

            // If rental has ended
            if ($now->gte($endDateTime)) {
                return 'Rental telah berakhir';
            }

            // Calculate remaining time using Carbon's diff methods
            $diff = $now->diff($endDateTime);

            // Format as "D day and H hours"
            if ($diff->days > 0) {
                if ($diff->h > 0) {
                    return $diff->days . ' hari dan ' . $diff->h . ' jam';
                } else {
                    return $diff->days . ' hari';
                }
            } else {
                if ($diff->h > 0) {
                    return $diff->h . ' jam';
                } else {
                    return 'Kurang dari 1 jam';
                }
            }
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Rental duration left calculation error: ' . $e->getMessage(), [
                'start_booking_date' => $this->start_booking_date,
                'end_booking_date' => $this->end_booking_date,
                'start_booking_time' => $this->start_booking_time,
                'end_booking_time' => $this->end_booking_time,
                'current_time' => Carbon::now()->toDateTimeString()
            ]);

            return 'Error menghitung sisa waktu';
        }
    }

    // Alternative method that returns array with more detailed info
    public function getRentalTimeInfo()
    {
        if (
            !$this->start_booking_date || !$this->end_booking_date ||
            !$this->start_booking_time || !$this->end_booking_time
        ) {
            return [
                'status' => 'incomplete_data',
                'message' => 'Data tidak lengkap',
                'duration_left' => null
            ];
        }

        try {
            $startDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->start_booking_date . ' ' . $this->start_booking_time
            );
            $endDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $this->end_booking_date . ' ' . $this->end_booking_time
            );

            $now = Carbon::now();

            if ($now->lt($startDateTime)) {
                $diff = $now->diff($startDateTime);

                $timeUntilStart = '';
                if ($diff->days > 0) {
                    if ($diff->h > 0) {
                        $timeUntilStart = $diff->days . ' hari dan ' . $diff->h . ' jam';
                    } else {
                        $timeUntilStart = $diff->days . ' hari';
                    }
                } else {
                    if ($diff->h > 0) {
                        $timeUntilStart = $diff->h . ' jam';
                    } else {
                        $timeUntilStart = 'Kurang dari 1 jam';
                    }
                }

                return [
                    'status' => 'not_started',
                    'message' => 'Rental belum dimulai',
                    'time_until_start' => $timeUntilStart
                ];
            }

            if ($now->gte($endDateTime)) {
                $diff = $endDateTime->diff($now);

                $overdueTime = '';
                if ($diff->days > 0) {
                    if ($diff->h > 0) {
                        $overdueTime = $diff->days . ' hari dan ' . $diff->h . ' jam';
                    } else {
                        $overdueTime = $diff->days . ' hari';
                    }
                } else {
                    if ($diff->h > 0) {
                        $overdueTime = $diff->h . ' jam';
                    } else {
                        $overdueTime = 'Kurang dari 1 jam';
                    }
                }

                return [
                    'status' => 'ended',
                    'message' => 'Rental telah berakhir',
                    'overdue_time' => $overdueTime
                ];
            }

            // Active rental - calculate remaining time
            $diff = $now->diff($endDateTime);

            $durationLeft = '';
            if ($diff->days > 0) {
                if ($diff->h > 0) {
                    $durationLeft = $diff->days . ' hari dan ' . $diff->h . ' jam';
                } else {
                    $durationLeft = $diff->days . ' hari';
                }
            } else {
                if ($diff->h > 0) {
                    $durationLeft = $diff->h . ' jam';
                } else {
                    $durationLeft = 'Kurang dari 1 jam';
                }
            }

            return [
                'status' => 'active',
                'message' => 'Rental sedang berlangsung',
                'duration_left' => $durationLeft,
                'days_left' => $diff->days,
                'hours_left' => $diff->h,
                'total_seconds_left' => $endDateTime->diffInSeconds($now)
            ];
        } catch (\Exception $e) {
            Log::error('Rental time info calculation error: ' . $e->getMessage(), [
                'order_id' => $this->id,
                'start_booking_date' => $this->start_booking_date,
                'end_booking_date' => $this->end_booking_date,
                'start_booking_time' => $this->start_booking_time,
                'end_booking_time' => $this->end_booking_time,
                'current_time' => Carbon::now()->toDateTimeString()
            ]);

            return [
                'status' => 'error',
                'message' => 'Error menghitung sisa waktu',
                'duration_left' => null
            ];
        }
    }
}
