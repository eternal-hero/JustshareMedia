<?php

namespace App\Exports;

use App\Models\Subscription;
use App\Models\TaxRate;
use App\Services\Subscription\SubscriptionCalculations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CsvExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        $subscriptions = Subscription::orderBy('created_at', 'desc');

        return $subscriptions;
    }

    /**
     * @return array
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function map($row): array
    {
        $salesRepsNames = [];
        $salesRepsCommission = [];
        foreach ($row->salesReps as $salesRep) {
            $salesRepsNames[] = $salesRep->name;
            if($salesRep->pivot->is_percentage) {
                $salesRepsCommission[] = $salesRep->pivot->commission . '%';
            } else {
                $salesRepsCommission[] = '$' . $salesRep->pivot->commission;
            }
        }
        $pcNames = [];
        $pcCommission = [];
        foreach ($row->partnerCompanies as $pc) {
            $pcNames[] = $pc->name;
            if($pc->pivot->is_percentage) {
                $pcCommission[] = $pc->pivot->commission . '%';
            } else {
                $pcCommission[] = '$' . $pc->pivot->commission;
            }
        }

        return [
            $row->id,
            $row->user->authorize_customer_id,
            $row->user->company,
            $row->user->first_name,
            $row->user->last_name,
            $row->user->email,
            $row->user->address,
            $row->user->city,
            $row->user->state,
            $row->user->zip,
            'Subscription',
            $row->term == 'yearly' ? 'Annual paid annual' : ($row->term == 'monthly' ? 'Monthly paid Monthly' : 'Annual paid monthly'),
            SubscriptionCalculations::calculateGross($row),
            SubscriptionCalculations::discountAmount($row),
            SubscriptionCalculations::couponCode($row),
            SubscriptionCalculations::couponCodeEndsAt($row),
            TaxRate::where('state_iso_code', $row->user->state)->first()->tax_rate,
            SubscriptionCalculations::calculateTax($row),
            SubscriptionCalculations::calculateTotal($row),
            $row->created_at,
            $row->status,
            $row->lastStatusChange ? $row->lastStatusChange->previous_state : '',
            $row->lastStatusChange ? $row->lastStatusChange->created_at : '',
            $row->start_at,
            $row->end_at,
            implode(', ', $salesRepsNames),
            implode(', ', $salesRepsCommission),
            count($row->partnerCompanies) > 0 ? 'Y' : 'N',
            implode(', ', $pcNames),
            implode(', ', $pcCommission),
            $row->lead ? $row->lead->name : ''
        ];
    }

    public function headings(): array
    {
        return [
            'Subscription ID',
            'Authorize Customer ID',
            'Company Name',
            'Customer Contact First Name',
            'Customer Contact Last Name',
            'Customer Email',
            'Customer Address',
            'Customer Address - City',
            'Customer Address - State',
            'Customer Address - Zip Code',
            'Order Type',
            'Product Type',
            'Gross Order Amount',
            'Discount Percentage (Amount)',
            'Discount Code',
            'Discount End Date',
            'Tax Rate',
            'Tax Amount',
            'Total Charge Amount',
            'Order Date',
            'Current Order Status',
            'Prior Order Status',
            'Order Status Change',
            'Subscription Start Date',
            'Subscription End Date',
            'Sales Rep',
            'Sales Rep Commission',
            'Partnership Flag',
            'Partner Company',
            'Partner Company Commission',
            'Lead Generation Source',
        ];
    }

}
