<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftBookings extends Model
{
    use HasFactory;
    
    protected $table = "draft_bookings";
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
            'user_id',
            'booking_type',
            'notice_type',
            'relevant_order',
            'plan',
            'work_permit',
            'permit_number',
            'work_place',
            'authourities',
            'borough_id',
            'work_type',
            'work_purpose',
            'work_shift',
            'from_day',
            'to_day',
            'from_date',
            'to_date',
            'agreement_101',
            'borough_council_names',
            'diversion_plans',
            'transport_for',
            'A_10',
            'prohibition_traffic',
            'order_year',
            'order_under_section',
            'given_notice',
            'place_at',
            'effect_orders',
            'vehicle_from',
            'from_month',
            'from_year',
            'until_time',
            'until_month',
            'traffic_signs_via',
            'signature',
            'person_title',
            'publish_date',
            'booking_date',
            'document',
            'price',
            'currency_symbol',
            'status',
            'proof_pdf',
            'pdf_status',
            'payment_invoice',
            'payment_recipt',
            'payment_status',
            'assign_to',
            'delivery_status',
            'delivery_proof',
            'transport_for_london',
            'road',
            'effect_of_the_order',
            'road_affected_by_the_order',
            'reasons_for_the_proposals',
            'proposed_order',
            'objections',
            'quoting_reference',
            'date_day',
            'date_month',
            'date_year',
            'type_suspension_values'
    ];
    
    
    // Relationship with the NewsPaper model
    public function newsPaper()
    {
        return $this->belongsTo(NewsPaper::class, 'news_paper_id');
    }

    // Relationship with the Area model
    public function area()
    {
        return $this->belongsTo(Area::class, 'area');
    }

    // Relationship with the Borough model
    public function borough()
    {
        return $this->belongsTo(Borough::class, 'borough_id');
    }
}
