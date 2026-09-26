<?php

namespace App\Http\Controllers;

use App\Models\GiftBox;
use App\Models\Occasion;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class GiftBoxController extends Controller
{
    public function __construct(
        private readonly WhatsAppService $whatsApp,
    ) {}
    public function index(Request $request)
    {
        $query = GiftBox::active()
            ->with(['occasions:id,name'])
            ->select(['id', 'name', 'slug', 'price', 'image', 'is_featured']);

        if ($request->filled('occasion')) {
            $query->whereHas('occasions', fn ($q) => $q->where('slug', $request->occasion));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        $sortField = $request->get('sort', 'sort_order');
        $sortDir = $request->get('dir', 'asc');

        $allowedSorts = ['price', 'sort_order'];
        if (! in_array($sortField, $allowedSorts)) {
            $sortField = 'sort_order';
        }

        $query->orderBy($sortField, $sortDir === 'desc' ? 'desc' : 'asc');

        $giftBoxes = $query->paginate(12)->withQueryString();

        $occasions = Occasion::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug'])
            ->get();

        return view('gift-boxes.index', compact('giftBoxes', 'occasions'));
    }

    public function show(string $slug)
    {
        $giftBox = GiftBox::active()
            ->with([
                'occasions:id,name,slug',
                'items.product:id,name,price,image',
                'reviews' => fn ($q) => $q->approved()->latest()->limit(10),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = GiftBox::active()
            ->where('id', '!=', $giftBox->id)
            ->whereHas('occasions', fn ($q) => $q->whereIn('id', $giftBox->occasions->pluck('id')))
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->limit(4)
            ->get();

        $boxDisplayName = trim(str_replace(['بوكس', 'صندوق', '❤️', '«', '»'], '', $giftBox->name));
        if (empty($boxDisplayName)) {
            $boxDisplayName = $giftBox->name;
        }

        $whatsappUrl = $this->whatsApp->generateGiftBoxUrl($giftBox, $boxDisplayName);

        return view('gift-boxes.show', compact('giftBox', 'related', 'whatsappUrl', 'boxDisplayName'));
    }
}
