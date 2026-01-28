# Inventory Management System

A full-stack Laravel 12 application for managing inventory across branches and stores. Blade + Tailwind CSS, no SPA.

**[Live demo](https://wanyonyi.blvdguide.com/)**

## Assumptions

- **Branches & stores**: Branch A has 1 store (Store A1). Branch B has 2 stores (Store B1, Store B2).
- **Stock**: Stored per store per product in a `stock` table (store_id, product_id, quantity).
- **Sales**: Reduce store stock and create a sale record (store, product, quantity, unit_price, sold_at). No approval workflow.
- **Transfers**: Two-step flow: request (pending) then complete. Completing decreases source and increases destination stock. Inter-branch and inter-store use the same logic.
- **Roles**: Stored on `users` as `role` with optional `branch_id` and `store_id` for scoping. New registrations get Store Manager role with no store (admin must assign).

## Role access

| Role            | Access                                                                 |
|-----------------|------------------------------------------------------------------------|
| Administrator   | All branches, all stores, all products, sales, and transfers.          |
| Branch Manager  | Only stores in their assigned branch.                                  |
| Store Manager   | Only their assigned store.                                             |

Dashboard, products, sales, and transfers are scoped to the user’s allowed stores (`User::allowedStoreIds()`).

## Stock movement flow

1. **Sale**  
   `SaleService::recordSale(storeId, productId, quantity, user)`  
   - In a DB transaction: lock stock row, check quantity, decrement stock, create `Sale` with unit_price from product.

2. **Transfer (request)**  
   `TransferService::requestTransfer(fromStoreId, toStoreId, productId, quantity, user)`  
   - Creates a `StockTransfer` with status `pending`. No stock change yet.

3. **Transfer (complete)**  
   `TransferService::completeTransfer(transferId)`  
   - In a DB transaction: ensure transfer is pending, lock source stock, decrement source, increment or create destination stock, set status `completed` and `completed_at`.

4. **Transfer (cancel)**  
   `TransferService::cancelTransfer(transferId)`  
   - Sets status to `cancelled` (no stock movement).

## How to run the project

### Requirements

- PHP 8.2+
- Composer
- Node.js & npm (for Vite/Tailwind)
- MySQL

### Setup

1. **Clone and install**

   ```bash
   cd /path/to/retailpay-inventory-system
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Configure database** in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. **Run migrations**:

   ```bash
   php artisan migrate
   ```

4. **Seed data** (branches, stores, 10 products, stock per store, 6 users):

   ```bash
   php artisan db:seed
   ```

5. **Frontend**

   ```bash
   npm install
   npm run build
   ```

   For development:

   ```bash
   npm run dev
   ```

6. **Start app**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000`. You will be redirected to login.

### Seeded users (password: `password`)

| Email               | Role          | Scope      |
|---------------------|---------------|------------|
| admin@example.com   | Administrator | All        |
| branch-a@example.com| Branch Manager| Branch A   |
| branch-b@example.com| Branch Manager| Branch B   |
| store-a1@example.com| Store Manager | Store A1   |
| store-b1@example.com| Store Manager | Store B1   |
| store-b2@example.com| Store Manager | Store B2   |


## Optional: Alpine.js

The layout includes Alpine.js from CDN for the mobile sidebar toggle. Modals can use Alpine for open/close; the blade component `x-modal` is available for confirmations.
