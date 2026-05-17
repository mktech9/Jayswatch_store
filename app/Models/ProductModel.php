<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'mst_product';

    protected $primaryKey = 'pro_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'pro_type',
        'pro_name',
        'pro_model',
        'pro_sku',
        'pro_gender',
        'pro_model_name',
        'pro_ref_num',
        'barcode_type',
        'slug',
        'brand',
        'watch_category',
        'calendar_type',
        'occasion',
        'collection',
        'category',
        'sport_type',
        'watch_type',
        'dial_type',
        'dial_colour',
        'dial_diameter',
        'case_shape',
        'case_material',
        'case_back',
        'strap_material',
        'strap_colour',
        'glass_material',
        'bezel',
        'bezel_function',
        'embellishment',
        'clasp_type',
        'color',
        'movement',
        'water_resistance',
        'functionality',
        'brand_warranty',
        'service_card',
        'year_of_card',
        'show_yearcard',
        'box',
        'paper',
        'hsn_code',
        'origin_country',
        'manufacturer',
        'packers',
        'unit',
        'condition',
        'purchase_date',
        'business_location',
        'display_location',
        'physical_location',
        'shop_warranty',
        'new_arrival',
        'manage_stock',
        'out_stock',
        'not_for_selling',
        'tata_cliq_product',
        'quantity',
        'product_desc',
        'pro_image',
        'pro_gallery',
        'pro_brochure',
        'video_type',
        'video_source',
        'enable_imei',
        'pro_tax',
        'product_type',
        'selling_tax_type',
        'purchase_type',
        'purchase_price_inclusive',
        'purchase_price_exclusive',
        'pro_margin',
        'selling_price_exclusive',
        'meta_title',
        'meta_description',
        'today_views',
        'approval_status',
        'status',
        'store_owner',
        'duplicate_ref',
        'admin_exclusive',
        'created_by',
        'created_at',
        'updated_by',
    ];

    public static function generateSKU($brand_id, $collection_name, $ref_num, $model_number)
    {
        // Fetch brand name
        $brand_name = DB::table('mst_brand')
            ->where('brand_id', $brand_id)
            ->value('brand_name');

        // brand first 4 chars
        $brandPart = strtoupper(substr(preg_replace('/\s+/', '', $brand_name ?? ''), 0, 4));

        // collection first 3 chars
        $collectionPart = strtoupper(substr(preg_replace('/\s+/', '', $collection_name ?? ''), 0, 3));

        // last 4 of ref number
        $refPart = strtoupper(substr($ref_num ?? '', -4));

        // first 3 of model number
        $modelPart = strtoupper(substr(preg_replace('/\s+/', '', $model_number ?? ''), 0, 3));

        // fallback safety for missing parts
        $brandPart = $brandPart ?: 'BRND';
        $collectionPart = $collectionPart ?: 'COL';
        $modelPart = $modelPart ?: 'MOD';
        $refPart = $refPart ?: '0000';

        // combine
        return $brandPart . $collectionPart . $modelPart . $refPart;
    }

    public static function generateSlug($pro_name, $watch_ref_number, $model_number)
    {
        // last 4 from watch ref number
        $refPart = substr(preg_replace('/\D/', '', $watch_ref_number ?? ''), -4);
        $refPart = $refPart ?: '0000';

        // first 3 from model number
        $modelPart = strtoupper(substr(preg_replace('/\s+/', '', $model_number ?? ''), 0, 3));
        $modelPart = strtolower($modelPart ?: 'mod');

        // slug text from name
        $baseSlug = strtolower(trim($pro_name));

        // replace spaces with -
        $baseSlug = preg_replace('/\s+/', '-', $baseSlug);

        // remove unwanted chars
        $baseSlug = preg_replace('/[^a-z0-9\-]/', '', $baseSlug);

        // final base format
        $slug = $baseSlug . '-' . $refPart . '-' . $modelPart;

        $originalSlug = $slug;
        $counter = 1;

        // ensure uniqueness
        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Relation Model
    public function brandInfo()
    {
        return $this->belongsTo(BrandModel::class, 'brand', 'brand_id');
    }

    public function movementInfo()
    {
        return $this->belongsTo(MovementModel::class, 'movement', 'm_id');
    }
}
