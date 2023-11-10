import os
os.environ['SURPRISE_DATA_FOLDER'] = '/home/site/wwwroot/surprise_data'
import sys
import json
import pandas as pd
import pymysql
from surprise import Dataset, Reader
from surprise.model_selection import train_test_split
from surprise import SVD

# Determine the current script directory
script_dir = os.path.dirname(os.path.abspath(__file__))

# Database connection parameters
db_host = 'icloth.mysql.database.azure.com'
db_user = 'iclothfyp'
db_password = 'Fyp123!@#'
db_name = 'eComDB'
db_ssl = os.path.join(script_dir, '../SSL_cert/DigiCertGlobalRootCA.crt.pem')

# Connect to the database
try:
    connection = pymysql.connect(
        host=db_host,
        user=db_user,
        password=db_password,
        db=db_name,
        ssl_ca=db_ssl
    )
except pymysql.MySQLError as e:
    print("Error: Could not connect to the MySQL database.")
    sys.exit(1)

try:
    with connection.cursor() as cursor:
        # Get the seller's user ID from the command-line arguments
        if len(sys.argv) > 1:
            seller_user_id = int(sys.argv[1])
        else:
            print("Error: User ID not provided.")
            sys.exit(1)

        # Fetch the seller's seller_id based on their user_id
        cursor.execute(
            "SELECT seller_id FROM Sellers WHERE user_id = %s",
            (seller_user_id,)
        )
        seller_id = cursor.fetchone()[0]

        # Check if the seller has any items attached to them
        cursor.execute(
            "SELECT COUNT(*) FROM Items WHERE seller_id = %s",
            (seller_id,)
        )
        item_count = cursor.fetchone()[0]

        if item_count > 0:
            # If the seller has items, recommend those items
            cursor.execute(
                "SELECT item_id FROM Items WHERE seller_id = %s",
                (seller_id,)
            )
            items_to_recommend = [row[0] for row in cursor.fetchall()]

            # Query item ratings from the database
            cursor.execute(
                "SELECT customer_id, item_id, rating_value FROM ItemRatings"
            )
            data = cursor.fetchall()

            # Create a DataFrame from the fetched data
            df = pd.DataFrame(data, columns=['customer_id', 'item_id', 'rating_value'])

            # Create a Surprise dataset from the DataFrame
            reader = Reader(rating_scale=(1, 5))
            dataset = Dataset.load_from_df(df[['customer_id', 'item_id', 'rating_value']], reader)

            # Build a train set
            trainset = dataset.build_full_trainset()

            # Build and train an SVD model
            model = SVD()
            model.fit(trainset)

            # Predict ratings for items to recommend
            predicted_ratings = {}
            for item_id in items_to_recommend:
                prediction = model.predict(seller_user_id, item_id)
                predicted_ratings[item_id] = prediction.est

            # Sort items by predicted rating (highest to lowest)
            sorted_predicted_items = sorted(predicted_ratings.items(), key=lambda x: x[1], reverse=True)

            # Display the top recommended items
            top_recommendations = [{"item_id": item_id, "predicted_rating": rating} for item_id, rating in sorted_predicted_items[:6]]

        else:
            # If the seller has no items, fetch top-rated items in their preferred category
            cursor.execute(
                "SELECT preferred_category FROM Sellers WHERE user_id = %s",
                (seller_user_id,)
            )
            preferred_category = cursor.fetchone()[0]

            cursor.execute(
                "SELECT item_id FROM Items WHERE category_id = %s",
                (preferred_category,)
            )
            items_to_recommend = [row[0] for row in cursor.fetchall()]

            top_recommendations = []

            if len(items_to_recommend) == 0:
                print("No items available for recommendations.")
                sys.exit(0)

            # Query item ratings from the database
            cursor.execute(
                "SELECT customer_id, item_id, rating_value FROM ItemRatings"
            )
            data = cursor.fetchall()

            # Create a DataFrame from the fetched data
            df = pd.DataFrame(data, columns=['customer_id', 'item_id', 'rating_value'])

            # Create a Surprise dataset from the DataFrame
            reader = Reader(rating_scale=(1, 5))
            dataset = Dataset.load_from_df(df[['customer_id', 'item_id', 'rating_value']], reader)

            # Build a train set
            trainset = dataset.build_full_trainset()

            # Build and train an SVD model
            model = SVD()
            model.fit(trainset)

            # Predict ratings for items in the preferred category
            predicted_ratings = {}
            for item_id in items_to_recommend:
                prediction = model.predict(seller_user_id, item_id)
                predicted_ratings[item_id] = prediction.est

            # Sort items by predicted rating (highest to lowest)
            sorted_predicted_items = sorted(predicted_ratings.items(), key=lambda x: x[1], reverse=True)

            # Display the top recommended items
            top_recommendations = [{"item_id": item_id, "predicted_rating": rating} for item_id, rating in sorted_predicted_items[:6]]

        # Print recommendations as JSON
        recommendations_json = json.dumps(top_recommendations)
        print(recommendations_json)

finally:
    connection.close()
