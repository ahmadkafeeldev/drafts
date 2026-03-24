# TRO GIS Map Integration

## Overview

This document describes the professional TRO (Traffic Regulation Orders) GIS map integration that has been added to your Laravel project. The map system uses OpenLayers with EPSG:27700 British National Grid projection and provides comprehensive annotation and order management capabilities.

## Features Implemented

### 🗺️ **Core Map Features**
- **OpenLayers Integration**: Professional mapping with EPSG:27700 projection
- **Base Maps**: OpenStreetMap tiles with proper coordinate transformation
- **Full Screen Mode**: Immersive mapping experience
- **Coordinate Display**: Real-time coordinate tracking in British National Grid

### 📊 **Order Management**
- **Dynamic Order Loading**: Fetches orders from your existing Laravel database
- **Order Status Layers**: 
  - Static (Rose)
  - Effective (Green) 
  - Proposed (Amber)
  - Moving (Lime)
  - Inventory (Sky)
- **Order Search**: Real-time filtering of orders
- **Order Actions**: Details, Confirm, Schedule, Delete
- **Order Highlighting**: Visual feedback on selection

### 🎨 **Annotation Tools**
- **Drawing Tools**:
  - Point markers with labels
  - Line strings
  - Polygons/Areas
  - Rectangles
  - Circles
  - Arrows (with proper arrow heads)
  - Text labels
- **Editing**: Modify existing annotations
- **Deletion**: Remove annotations with group support
- **Layer Targeting**: Draw to specific layers (Static, Effective, Proposed, etc.)

### 📏 **Measurement Tools**
- **Distance Measurement**: Live measurement in meters
- **Area Measurement**: Calculate polygon areas
- **Visual Feedback**: Real-time measurement tooltips

### 💾 **Data Management**
- **GeoJSON Export**: Export annotations as GeoJSON
- **GeoJSON Import**: Import GeoJSON data to target layers
- **Clipboard Support**: Copy/export functionality
- **Coordinate System**: Full EPSG:27700 support

## File Structure

### New Files Created
```
resources/views/users/tro_gis_map.blade.php    # Main map view
resources/views/layouts/drafts/gis.blade.php   # GIS-specific layout
public/js/tro-gis-map.js                       # Map JavaScript logic
app/Http/Controllers/TroGisController.php      # API endpoints
database/migrations/2026_03_24_084748_add_geometry_to_bookings_table.php
```

### Modified Files
```
app/Http/Controllers/Drafts/DraftsController.php  # Added troGisMap method
app/Models/Bookings.php                          # Added geometry support
routes/web.php                                   # Added GIS routes
resources/views/layouts/drafts/sidebar.blade.php # Added map link
```

## API Endpoints

All API endpoints are protected by authentication and integrate with your existing user system:

- `GET /user/api/orders` - Fetch orders for the map
- `GET /user/api/bookings` - Get booking data
- `POST /user/api/annotations/store` - Save annotations
- `DELETE /user/api/annotations/delete` - Delete annotations
- `GET /user/api/boroughs` - Get borough data with coordinates
- `GET /user/api/areas` - Get area data with coordinates

## Database Schema

### New Columns in `bookings` table:
- `geometry` (JSON) - Stores GeoJSON geometry data
- `latitude` (decimal:10,8) - Latitude coordinate
- `longitude` (decimal:11,8) - Longitude coordinate  
- `map_layer` (string) - Layer classification (static, effective, etc.)
- `effective_from` (date) - Order effective date

## Integration with Existing System

### Order Data Flow
1. **Existing Bookings**: Automatically fetched and displayed on map
2. **Coordinate Generation**: London-based coordinates based on borough/area
3. **Status Classification**: Smart status detection based on booking properties
4. **Geometry Support**: Ready for future coordinate storage

### User Authentication
- Uses existing Laravel authentication
- Respects user permissions (only shows user's own bookings)
- CSRF protection on all API calls

### Navigation
- Added "TRO GIS Map" link to sidebar
- Accessible at `/user/drafts/tro-gis-map`
- Full-screen layout for optimal mapping experience

## Usage Instructions

### Accessing the Map
1. Log in to your Laravel application
2. Click "TRO GIS Map" in the sidebar navigation
3. The map will load with your existing booking data

### Using Drawing Tools
1. Ensure "Annotation mode" is ON (toggle in sidebar)
2. Select a drawing tool (Point, Line, Area, etc.)
3. Choose target layer from dropdown
4. Click on map to draw
5. For text: enter label when prompted

### Managing Orders
1. **Search**: Use the search box to filter orders
2. **Select**: Click on order in list or map
3. **Actions**: Use Details, Confirm, Schedule, Delete buttons
4. **Layers**: Toggle visibility with layer buttons

### Import/Export
1. **Export**: Click Export button to download annotations as GeoJSON
2. **Import**: Click Import, paste GeoJSON, choose target layer
3. **Copy**: Use Copy button for clipboard operations

## Technical Details

### Coordinate System
- **Projection**: EPSG:27700 (British National Grid)
- **Transformation**: Automatic WGS84 to BNG conversion
- **Accuracy**: High-precision coordinate handling

### Performance
- **Lazy Loading**: Orders loaded on-demand
- **Efficient Rendering**: OpenLayers vector layers
- **Memory Management**: Proper cleanup of map resources

### Browser Support
- **Modern Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile**: Responsive design with touch support
- **Dependencies**: OpenLayers, Proj4, TailwindCSS

## Future Enhancements

### Recommended Next Steps
1. **Real Coordinates**: Add coordinate input to booking forms
2. **Advanced Styling**: Custom order styling based on type
3. **Print Support**: Map printing functionality
4. **Offline Mode**: Cache maps for offline use
5. **Mobile App**: React Native integration

### Database Optimization
1. **Spatial Indexing**: Add spatial indexes for performance
2. **Geometry Types**: Consider PostGIS for advanced spatial queries
3. **Caching**: Redis caching for frequent map data

## Troubleshooting

### Common Issues
1. **Map Not Loading**: Check OpenLayers CDN connectivity
2. **Orders Not Showing**: Verify API authentication
3. **Drawing Issues**: Ensure annotation mode is ON
4. **Coordinate Problems**: Check projection settings

### Debug Mode
- Open browser developer tools
- Check console for JavaScript errors
- Verify network requests to API endpoints
- Inspect map layer visibility

## Support

For technical support or questions about the TRO GIS integration:
1. Check this documentation first
2. Review browser console for errors
3. Verify Laravel logs for API issues
4. Test with fresh browser session

---

**Integration Completed**: March 24, 2026
**Laravel Version**: 11.x
**Map System**: OpenLayers 9.x with EPSG:27700 support
