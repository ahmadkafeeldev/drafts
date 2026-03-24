<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\DraftBookings;
use App\Models\Borough;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TroGisController extends Controller
{
    /**
     * Get orders for the TRO GIS map
     */
    public function getOrders(): JsonResponse
    {
        try {
            $orders = Bookings::with(['newsPaper', 'area', 'borough'])
                ->where('user_id', Auth::id())
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => 'T' . $booking->id,
                        'title' => $booking->title ?? 'Order ' . $booking->id,
                        'type' => $booking->order_type ?? 'no_waiting',
                        'status' => $this->getBookingStatus($booking),
                        'effective_from' => $booking->effective_from ?? now()->format('Y-m-d'),
                        'geometry' => $this->generateGeometryForBooking($booking),
                        'coordinates' => $this->getCoordinatesForBooking($booking),
                        'booking_id' => $booking->id
                    ];
                });

            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch orders'], 500);
        }
    }

    /**
     * Get bookings data for the map
     */
    public function getBookings(): JsonResponse
    {
        try {
            $bookings = DraftBookings::with(['borough', 'area'])
                ->where('user_id', Auth::id())
                ->get()
                ->map(function ($booking) {
                    return [
                        'id' => $booking->id,
                        'title' => $booking->title ?? 'Draft Booking ' . $booking->id,
                        'type' => $booking->booking_type ?? 'draft',
                        'status' => 'draft',
                        'effective_from' => $booking->created_at->format('Y-m-d'),
                        'geometry' => $this->generateGeometryForDraft($booking),
                        'coordinates' => $this->getCoordinatesForDraft($booking),
                        'borough_id' => $booking->borough,
                        'area_id' => $booking->area
                    ];
                });

            return response()->json($bookings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch bookings'], 500);
        }
    }

    /**
     * Save annotation data
     */
    public function saveAnnotation(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string',
                'geometry' => 'required|array',
                'layer' => 'required|string',
                'label' => 'nullable|string'
            ]);

            // Here you would save the annotation to your database
            // For now, we'll just return success
            
            return response()->json([
                'success' => true,
                'message' => 'Annotation saved successfully',
                'data' => $validated
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save annotation'], 500);
        }
    }

    /**
     * Delete annotation
     */
    public function deleteAnnotation(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'annotation_id' => 'required|string'
            ]);

            // Here you would delete the annotation from your database
            // For now, we'll just return success
            
            return response()->json([
                'success' => true,
                'message' => 'Annotation deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete annotation'], 500);
        }
    }

    /**
     * Get boroughs with coordinates
     */
    public function getBoroughs(): JsonResponse
    {
        try {
            $boroughs = Borough::all()->map(function ($borough) {
                return [
                    'id' => $borough->id,
                    'name' => $borough->name,
                    'coordinates' => $this->getBoroughCoordinates($borough)
                ];
            });

            return response()->json($boroughs);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch boroughs'], 500);
        }
    }

    /**
     * Get areas with coordinates
     */
    public function getAreas(): JsonResponse
    {
        try {
            $areas = Area::all()->map(function ($area) {
                return [
                    'id' => $area->id,
                    'name' => $area->name,
                    'borough_id' => $area->borough_id,
                    'coordinates' => $this->getAreaCoordinates($area)
                ];
            });

            return response()->json($areas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch areas'], 500);
        }
    }

    /**
     * Determine booking status based on booking properties
     */
    private function getBookingStatus($booking): string
    {
        // Logic to determine status based on your booking properties
        if (isset($booking->status)) {
            return $booking->status;
        }
        
        // Default logic - you can customize this
        if ($booking->created_at->diffInDays(now()) > 30) {
            return 'effective';
        } elseif ($booking->created_at->diffInDays(now()) > 7) {
            return 'proposed';
        } else {
            return 'static';
        }
    }

    /**
     * Generate geometry for booking
     */
    private function generateGeometryForBooking($booking): array
    {
        // This would typically come from your database
        // For demo purposes, we'll generate sample geometry
        $baseCoords = $this->getBaseCoordinatesForBooking($booking);
        
        return [
            'type' => 'LineString',
            'coordinates' => $baseCoords
        ];
    }

    /**
     * Generate geometry for draft booking
     */
    private function generateGeometryForDraft($booking): array
    {
        $baseCoords = $this->getBaseCoordinatesForDraft($booking);
        
        return [
            'type' => 'LineString', 
            'coordinates' => $baseCoords
        ];
    }

    /**
     * Get coordinates for booking
     */
    private function getCoordinatesForBooking($booking): array
    {
        return $this->getBaseCoordinatesForBooking($booking);
    }

    /**
     * Get coordinates for draft booking
     */
    private function getCoordinatesForDraft($booking): array
    {
        return $this->getBaseCoordinatesForDraft($booking);
    }

    /**
     * Get base coordinates for booking (London area)
     */
    private function getBaseCoordinatesForBooking($booking): array
    {
        // Use borough/area to generate coordinates if available
        if ($booking->borough && $booking->borough->name) {
            return $this->getLondonCoordinates($booking->borough->name);
        }
        
        // Default London coordinates
        return [
            [-0.1420, 51.4010],
            [-0.1370, 51.4040],
            [-0.1310, 51.4070]
        ];
    }

    /**
     * Get base coordinates for draft booking
     */
    private function getBaseCoordinatesForDraft($booking): array
    {
        if ($booking->borough && $booking->borough->name) {
            return $this->getLondonCoordinates($booking->borough->name);
        }
        
        return [
            [-0.1180, 51.4045],
            [-0.1135, 51.4072],
            [-0.1090, 51.4095]
        ];
    }

    /**
     * Get coordinates for borough
     */
    private function getBoroughCoordinates($borough): array
    {
        return $this->getLondonCoordinates($borough->name);
    }

    /**
     * Get coordinates for area
     */
    private function getAreaCoordinates($area): array
    {
        if ($area->borough && $area->borough->name) {
            return $this->getLondonCoordinates($area->borough->name);
        }
        
        return $this->getLondonCoordinates('Westminster');
    }

    /**
     * Get London coordinates for different areas
     */
    private function getLondonCoordinates($areaName): array
    {
        $coordinates = [
            'Bromley' => [
                [-0.1420, 51.4010],
                [-0.1370, 51.4040],
                [-0.1310, 51.4070]
            ],
            'Croydon' => [
                [-0.0980, 51.4090],
                [-0.0930, 51.4108],
                [-0.0880, 51.4130]
            ],
            'Westminster' => [
                [-0.1060, 51.5025],
                [-0.1000, 51.5048],
                [-0.0950, 51.5072]
            ],
            'Camden' => [
                [-0.1220, 51.5060],
                [-0.1188, 51.5080],
                [-0.1160, 51.5062]
            ],
            'Kensington & Chelsea' => [
                [-0.1180, 51.5045],
                [-0.1135, 51.5072],
                [-0.1090, 51.5095]
            ]
        ];

        return $coordinates[$areaName] ?? $coordinates['Westminster'];
    }
}
