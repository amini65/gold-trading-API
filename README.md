# Gold Trading API

A Laravel-based API for trading raw gold (طلای آبشده) between users with automatic order matching.

## Features

- Buy and sell order placement
- Automatic order matching based on price and availability
- Tiered commission system
- User balance management
- Order history and trade records
- RESTful API design
- No authentication required

## Commission Structure

- Up to 1g: 2%
- 1g to 10g: 1.5%
- Over 10g: 1%
- Minimum fee: 50,000 Toman
- Maximum fee: 5,000,000 Toman

## API Endpoints

### Orders
- GET `/api/order` - List all orders
- POST `/api/order/store` - Create a new order
- GET `/api/order/show/{id}` - Get order details
- POST `/api/order/cancelled/{id}` - Cancel an order

### Trade Historys
- GET `/api/order/history/{id}` - Get specific trade user history

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

## Testing

The project includes test users with predefined balances:

- Ahmad: 100 million Toman, 0g gold
- Reza: 50 million Toman, 0g gold
- Akbar: 0 Toman, 8.517g gold
- Admin: 0 Toman, 0g gold (receives all commissions)

## Example API Usage

### Create a Buy Order
```bash
curl -X POST http://localhost:8000/api/order/store \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 4,
    "order_type": "buy",
    "amount": 2,
    "price": 10000000
  }'
```

### Create a Sell Order
```bash
curl -X POST http://localhost:8000/api/order/store \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 2,
    "order_type": "sell",
    "amount": 8,
    "price": 10000000
  }'
```

### Get Trade History
```bash
curl -X GET "http://localhost:8000/api/order/history/{userId}?start_date=2024-03-20&end_date=2024-03-21"
```

## Technical Details

- Laravel 12.x
- PHP 8.2+
- MySQL/PostgreSQL
- RESTful API design
- SOLID principles
- Clean Code practices
- Service-based architecture
- Repository Pattern
- Commission handling via trait
- Row-level locking for concurrency control

## Postman Collection

A Postman collection is available in the `postman` directory. Import it into Postman to test the API endpoints.

