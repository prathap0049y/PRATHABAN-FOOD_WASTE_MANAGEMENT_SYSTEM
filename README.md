# PRATHABAN-FOOD_DONATION_MANAGEMENT_SYSTEM
# 🍲 Food Waste Management System

A web-based platform built using **PHP, MySQL, HTML, CSS, and JavaScript** (no AJAX or external APIs) to efficiently manage food donations from individuals and organizations, helping reduce food waste and feed the needy. The system runs on **localhost using XAMPP** and includes separate panels for **Donor, Delivery Person, and Admin**.

---

## 🚀 Features

### 👤 Donor Panel (Normal Donor / Organization)
- Donor registration & login
- Dynamic donation forms:
  - Normal Donors: Name, Food Type, Quantity, Expiry, Location
  - Organizations: Org Name, Event Type, Food Info, Expiry
- View donation status (Accepted / Rejected)
- Earn reward points for successful donations
- Track donation history

### 🚚 Delivery Person Panel
- Login & dashboard
- View assigned donations
- Mark as "Picked Up" and "Delivered"
- View delivery history

### 🛠️ Admin Panel
- Admin login & dashboard
- Accept / Reject donations
- Assign delivery persons
- Monitor donation activity
- Track food expiry reports
- Manage gamification rewards
- Generate leaderboard of top donors
- Backup database manually or automatically

---

## ⏰ Cron Jobs

- **Food Expiry Checker**
  - Checks expiry date from donation table daily
  - Marks expired donations
  - Alerts admin automatically

- **Backup System**
  - Backs up MySQL database
  - Runs using **Windows Task Scheduler**

---

## 🏅 Gamification & Rewards

- Donors earn points per successful donation
- Points redeemable for:
  - Badges
  - Certificates
  - Gifts
- Leaderboard highlights top contributors

---

## 📊 Searchable & Exportable Tables

- Integrated in Admin & Donor panels
- Features:
  - Search bar
  - Column sorting
  - Export to Excel / PDF

---

## 🧰 Technologies Used

| Tech Stack    | Description                          |
|---------------|--------------------------------------|
| Frontend      | HTML5, CSS3, JavaScript              |
| Backend       | PHP (no AJAX used)                   |
| Database      | MySQL                                |
| Server        | Apache (XAMPP on localhost)          |
| Task Scheduler| Windows Task Scheduler for cron jobs |

---

## 📂 Folder Structure

/food-waste-management-system/
│
├── /admin/ # Admin Panel
├── /donor/ # Donor Panel (Normal & Organization)
├── /delivery/ # Delivery Person Panel
├── /backup/ # DB backup scripts
├── /cron/ # Cron job PHP files
├── /assets/ # CSS, images, etc.
├── database.sql # MySQL Database File
└── README.md


---

## 🔧 Setup Instructions (Localhost)

1. Clone the repository or download the ZIP
2. Copy the folder into `htdocs` (XAMPP)
3. Import `database.sql` into **phpMyAdmin**
4. Update database credentials in config files
5. Start Apache & MySQL via XAMPP Control Panel
6. Access panels in browser:
   - Donor: `http://localhost/food-waste-management-system/donor/`
   - Delivery: `http://localhost/food-waste-management-system/delivery/`
   - Admin: `http://localhost/food-waste-management-system/admin/`

---

## ✅ Future Improvements

- Email & SMS notifications
- Real-time delivery tracking via map
- Mobile responsive design
- QR code-based donation tracking

---

## 📃 License

This project is for educational purposes only.

---

## 🙌 Acknowledgements

Developed as part of M.Sc. Computer Science final year project to contribute towards reducing food waste and supporting the community.

---



