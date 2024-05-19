<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class BirthdayPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $navigationGroup = "Church Member";

    protected static ?int $navigationSort = 4;

    protected static ?string $title = "Birthday";

    protected static string $view = 'filament.pages.birthday';

    public array $birthdayMember = [];

    public array $memberByDay = [];

    public string $startDate = "";

    public string $endDate = "";

    public bool $isCustom = false;

    public ?array $data = [];

    public function mount()
    {
        $now = Carbon::now();

        $startDate = $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $this->filterMember($startDate, $endDate);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns([
                        "sm" => 2
                    ])
                    ->schema([
                        DatePicker::make('start_date')
                            ->required()
                            ->date()
                            ->columns(2),
                        DatePicker::make('end_date')
                            ->required()
                            ->date()
                            ->columns(2)
                    ])
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $data = $this->form->getState();

        if (!isset($data['start_date']) || !isset($data["end_date"])) {
            return false;
        }

        $now = Carbon::now();

        $startDate = $now->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $endDate = $now->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $isCustom = !($startDate == $data['start_date'] && $endDate == $data['end_date']);
        $this->filterMember($data['start_date'], $data['end_date'], $isCustom);
    }

    public function filterMember(string $startDate, string $endDate, bool $isCustom = false)
    {

        $period = CarbonPeriod::create($startDate, $endDate);

        $members = Member::where(function ($query) use ($period) {
            foreach ($period as $date) {
                $query->orWhereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [$date->format("m-d")]);
            }
        })->whereIn('status', [Member::STATUS_ACTIVE, Member::STATUS_UNAPPROVED])
            ->selectRaw("*, DATE_FORMAT(birth_date, '%m-%d') as date")
            ->orderByRaw("MONTH(birth_date) ASC")
            ->orderByRaw("DAY(birth_date) ASC")
            ->get();

        // dd($members);
        $memberByDay = [];
        foreach ($period as $date) {
            $arrTemp = $members->where("date", "=", $date->format("m-d"));
            if ($arrTemp->count() > 0) {
                $arrTemp = $arrTemp->map(function ($item) use ($date) {
                    $item->url = MemberResource::getUrl('view', ["record" => $item->id]);
                    $item->ageOnDate = $item->getAgeByDate($date);
                    return $item;
                });
                $memberByDay[$date->format("Y-m-d")] = [
                    "title" => $date->isoFormat('dddd, D MMMM Y'),
                    "data" => $arrTemp
                ];
            }
        }

        $this->birthdayMember = $members->toArray();
        $this->memberByDay = $memberByDay;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->isCustom = $isCustom;
    }
}
