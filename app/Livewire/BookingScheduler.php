<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Field;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Livewire\Component;

class BookingScheduler extends Component
{
    public Field $field;
    public $selectedDate;

    public array $selectedTimeSlots = [];

    // Properti ini akan dihitung ulang setiap kali ada perubahan
    public Collection $timeSlots;
    public Collection $bookedSlots;

    public function mount(Field $field)
    {
        $this->field = $field;
        $this->selectedDate = now()->format('Y-m-d');
        $this->loadSlots();
    }

    // Fungsi ini akan dipanggil setiap kali $selectedDate berubah
    public function updatedSelectedDate()
    {
        $this->loadSlots();
        $this->reset('selectedTimeSlots'); // Kosongkan pilihan saat ganti tanggal
    }

    public function loadSlots()
    {
        $dayOfWeek = Carbon::parse($this->selectedDate)->format('l');

        // Ambil semua jadwal operasional untuk hari yang dipilih
        $schedules = $this->field->schedules()->where('day_of_week', $dayOfWeek)->where('is_active', true)->orderBy('start_time')->get();

        if ($schedules->isEmpty()) {
            $this->timeSlots = collect();
            $this->bookedSlots = collect();
            return;
        }

        // Setiap jadwal adalah satu slot: [start_time - end_time]
        $slots = $schedules->map(function($schedule) {
            return [
                'start' => $schedule->start_time,
                'end' => $schedule->end_time,
                'label' => Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . Carbon::parse($schedule->end_time)->format('H:i'),
            ];
        });
        $this->timeSlots = $slots->values();

        // Ambil semua slot yang sudah dibooking pada tanggal yang dipilih
        $this->bookedSlots = Booking::where('field_id', $this->field->id)
            ->where('booking_date', $this->selectedDate)
            ->where(function ($query) {
                // Slot dianggap terisi JIKA:
                // 1. Statusnya sudah confirmed/completed
                $query->whereIn('status', ['confirmed', 'completed'])
                    // ATAU
                    // 2. Statusnya pending TAPI belum melewati waktu kedaluwarsa
                    ->orWhere(function($subQuery) {
                        $subQuery->where('status', 'pending')
                                ->where('expires_at', '>', now());
                    });
            })
            ->get()
            ->pluck('start_time');
    }

    public function toggleTimeSlot(string $time)
    {
        // Cek apakah slot sudah dibooking, jika ya, jangan lakukan apa-apa
        if ($this->bookedSlots->contains($time)) {
            return;
        }

        // Hanya boleh memilih satu slot saja
        if (in_array($time, $this->selectedTimeSlots)) {
            $this->selectedTimeSlots = [];
        } else {
            $this->selectedTimeSlots = [$time];
        }
    }
    
    // Properti virtual untuk menghitung total harga
    public function getTotalPriceProperty()
    {
        if (empty($this->selectedTimeSlots)) return 0;

        $dayOfWeek = Carbon::parse($this->selectedDate)->format('l');
        $schedules = $this->field->schedules()->where('day_of_week', $dayOfWeek)->where('is_active', true)->get();

        $total = 0;
        foreach ($this->selectedTimeSlots as $selectedStart) {
            $schedule = $schedules->firstWhere('start_time', $selectedStart); 
            if ($schedule) {
                $total += $schedule->price_per_hour;
            }
        }
        return $total;
    }


    public function render()
    {
        return view('livewire.booking-scheduler');
    }
}