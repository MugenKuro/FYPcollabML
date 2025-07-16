# iCloth - E-commerce Platform with Recommender System

## Project Overview
iCloth is a comprehensive e-commerce platform specializing in clothing and fashion accessories, featuring an integrated machine learning-based recommender system. This Final Year Project (FYP) combines traditional e-commerce functionality with personalized product recommendations to enhance user experience and increase sales conversion.

## Video Demo
[![Watch the video](https://img.youtube.com/vi/d_oyFZ4EeCc/maxresdefault.jpg)](https://www.youtube.com/watch?v=d_oyFZ4EeCc)

## Key Features

### 🛍️ E-commerce Core Functionality
- **User Management**: Customer registration, authentication, and profile management
- **Seller Portal**: Business and individual seller registration with verification system
- **Product Catalog**: Comprehensive item listing with categories, images, and details
- **Shopping Cart**: Add to cart, quantity management, and checkout process
- **Order Management**: Purchase history, order tracking, and payment processing
- **Rating System**: Customer reviews and ratings for products
- **Admin Panel**: Category management, seller approval, and platform oversight

### 🤖 Machine Learning Recommender System
- **Customer Recommendations**: Personalized product suggestions based on user preferences and behavior
- **Seller Recommendations**: Intelligent product insights for sellers based on market trends
- **Collaborative Filtering**: Uses SVD (Singular Value Decomposition) algorithm for recommendation generation
- **Gender-based Filtering**: Recommendations tailored to user demographics
- **Category-based Recommendations**: Suggestions within seller's preferred categories

### 📱 User Interface
- **Responsive Design**: Mobile-friendly interface using Bootstrap
- **Customer Dashboard**: Personalized shopping experience with recommendations
- **Seller Dashboard**: Inventory management, sales analytics, and revenue reporting
- **Admin Interface**: Platform management and oversight tools

## Technology Stack

### Backend
- **PHP**: Server-side scripting and business logic
- **MySQL**: Database management (hosted on Azure)
- **Python**: Machine learning algorithms and data processing
- **Composer**: PHP dependency management

### Frontend
- **HTML/CSS**: Structure and styling
- **JavaScript**: Interactive functionality
- **Bootstrap**: Responsive design framework
- **jQuery**: DOM manipulation and AJAX requests

### Machine Learning
- **Python Libraries**:
  - `scikit-surprise`: Collaborative filtering algorithms
  - `pandas`: Data manipulation and analysis
  - `pymysql`: Database connectivity
  - `json`: Data serialization

### Infrastructure
- **Azure MySQL Database**: Cloud-based database hosting
- **SSL Certificate**: Secure database connections
- **File Upload System**: Image storage for products and profiles

## Project Structure

```
FYPcollabML/
├── admin/                 # Admin panel functionality
├── seller/                # Seller-specific features
├── customer/              # Customer recommender system
├── controller/            # MVC controllers
├── entity/                # Database models and entities
├── css/                   # Stylesheets
├── js/                    # JavaScript files
├── images/                # Product images, logos, profile pictures
├── db/                    # Database schemas and scripts
├── SSL_cert/              # SSL certificates for secure connections
└── python/                # Machine learning scripts
```

## Database Schema
The system uses a MySQL database with the following main tables:
- `Users`: User authentication and basic information
- `Customers`: Customer-specific data and preferences
- `Sellers`: Seller profiles and business information
- `Items`: Product catalog and details
- `Categories`: Product categorization system
- `ItemRatings`: Customer reviews and ratings
- `OrderHistory`: Purchase records and transaction history

## Recommender System Details

### Customer Recommendations
- Analyzes user ratings and purchase history
- Filters products by user gender and relevant categories
- Uses collaborative filtering to predict user preferences
- Returns top 5 personalized product recommendations

### Seller Recommendations
- Provides insights based on seller's preferred categories
- Analyzes market trends and customer ratings
- Helps sellers identify popular products in their niche
- Supports inventory planning and business decisions

## Installation & Setup

1. **Database Setup**: Import the database schema from `db/eComDBver2.sql`
2. **Dependencies**: Run `composer install` to install PHP dependencies
3. **Python Requirements**: Install required Python libraries for the recommender system
4. **Configuration**: Update database connection settings in entity files
5. **SSL Setup**: Configure SSL certificates for secure database connections

## Usage

### For Customers
1. Register/Login to the platform
2. Browse products by category
3. View personalized recommendations
4. Add items to cart and checkout
5. Rate and review purchased products

### For Sellers
1. Register as individual or business seller
2. Wait for admin approval
3. Add products to inventory
4. View sales analytics and recommendations
5. Manage orders and customer interactions

### For Administrators
1. Manage product categories
2. Approve/reject seller applications
3. Monitor platform activity
4. Handle customer support requests

## Future Enhancements
- Advanced analytics dashboard
- Mobile application
- Social media integration
- Enhanced recommendation algorithms
- Multi-language support
- Advanced search and filtering options

## Contribution
Final Year Project - Collaborative Machine Learning E-commerce Platform
- visit blog for more details: https://fyp23s302.wordpress.com/
