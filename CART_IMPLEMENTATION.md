# Cart Functionality Implementation Guide

## Overview
This document outlines the complete cart functionality implemented for the E-Commerce application.

## Features Implemented

### 1. **Cart Storage System**
- **Not Logged In**: Cart items stored in cookies (30-day expiration)
- **Logged In**: Cart items stored in session
- **On Login**: Cookies automatically migrate to session, then cookies are cleared

### 2. **Cart Operations**

#### Add to Cart
- Click "Add to Cart" button on product
- Quantity selector takes the value (defaults to 1)
- Items stored with product_id and quantity
- Works for both logged-in and non-logged-in users

#### Update Cart Item
- Modify quantity in cart page
- POST to `/cart/update` with product_id and quantity
- Quantity of 0 removes the item

#### Remove Item
- Remove individual items from cart
- POST to `/cart/remove` with product_id

#### Clear All Cart
- Remove all items at once
- POST to `/cart/clear`
- Clears both cookies and session

### 3. **Cart Data Structure**
```
Cart Item: {
    "product_id": 1,
    "quantity": 2
}
```

## Files Created/Modified

### New Files
1. **app/Services/CartService.php**
   - Core service handling all cart operations
   - Methods: addToCart, updateCartItem, removeFromCart, clearCart, getCart, getCartCount, migrateCartFromCookieToSession

2. **routes/web.php (Cart Routes)**
   ```
   POST /cart/add          - Add item to cart
   POST /cart/update       - Update cart item quantity
   POST /cart/remove       - Remove item from cart
   POST /cart/clear        - Clear all cart items
   GET /cart               - Get cart contents (JSON)
   ```

### Modified Files
1. **app/Http/Controllers/Auth/Client/CartController.php**
   - Added: addToCart(), updateCart(), removeFromCart(), clearCart(), getCart() methods

2. **app/Http/Controllers/Auth/Client/ClientAuthController.php**
   - Added CartService import
   - Added CartService::migrateCartFromCookieToSession() in login method

3. **resources/views/welcome.blade.php**
   - Added data-product-id attribute to cart button
   - Added add-to-cart-btn class for JavaScript targeting
   - Added JavaScript event listener for cart button clicks
   - Sends AJAX POST request to /cart/add

4. **resources/views/layouts/client/client-main.blade.php**
   - Added `<meta name="csrf-token">` for CSRF protection

## How It Works

### Step 1: User Not Logged In
1. User clicks "Add to Cart" button
2. JavaScript captures product ID and quantity
3. Sends AJAX request to `/cart/add`
4. CartService checks: user not authenticated → stores in cookie
5. Cookie name: `cart_items` (JSON encoded array)
6. Success message shows cart count

### Step 2: User Logs In
1. User submits login form
2. If credentials valid, Auth::attempt succeeds
3. Session regenerated
4. **CartService::migrateCartFromCookieToSession()** runs:
   - Reads `cart_items` cookie
   - Moves data to session
   - Deletes the cookie
5. User redirected to home

### Step 3: User Logged In - Add to Cart
1. User clicks "Add to Cart"
2. JavaScript sends AJAX request
3. CartService checks: user authenticated → stores in session
4. Session key: `cart_items`

### Step 4: Cart Page Operations (Later Implementation)
- Edit quantity
- Remove items
- Clear all
- View total price

## API Endpoints

### Add to Cart
```
POST /cart/add
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 2
}

Response: {
    "message": "Product added to cart",
    "cartCount": 3
}
```

### Update Cart
```
POST /cart/update
Content-Type: application/json

{
    "product_id": 1,
    "quantity": 5
}
```

### Remove from Cart
```
POST /cart/remove
Content-Type: application/json

{
    "product_id": 1
}
```

### Clear Cart
```
POST /cart/clear
```

### Get Cart
```
GET /cart

Response: {
    "cart": {...},
    "cartCount": 5
}
```

## JavaScript Implementation
- Event listener on all `.add-to-cart-btn` buttons
- Fetches quantity from closest input[type="number"]
- Uses Fetch API for AJAX requests
- Includes CSRF token from meta tag
- Shows success/error alerts
- Resets quantity input after adding

## Security
- CSRF token required for all POST requests
- Product ID and quantity validated server-side
- Authentication checks in CartService
- Cookie secured with appropriate flags

## Testing Checklist
- [ ] Add product to cart without logging in
- [ ] Check if cookie is created (Browser DevTools > Storage > Cookies)
- [ ] Log in and verify cart items appear
- [ ] Verify cookie is deleted after login
- [ ] Add more items while logged in
- [ ] Verify items persist in session
- [ ] Log out and log back in - cart should be gone (no more cookies)
- [ ] Test quantity updates
- [ ] Test item removal
- [ ] Test clear all

## Next Steps
- Create cart page UI (without changing existing design)
- Display all cart items with product details
- Allow inline editing of quantities
- Allow item removal
- Show cart total/subtotal
- Checkout functionality

## Notes
- UI remains unchanged as requested
- Only JavaScript was added to handle button clicks
- All business logic in CartService for reusability
- Compatible with future cart page implementation
