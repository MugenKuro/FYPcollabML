import os
os.environ['SURPRISE_DATA_FOLDER'] = '/home/site/wwwroot/surprise'
import sys
from surprise import Dataset, Reader
from surprise.model_selection import train_test_split
from surprise import SVD
import pymysql
import json
import pandas as pd

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
    #print("SUCCESS: Connection to Remote MySQL instance succeeded")
except pymysql.MySQLError as e:
    #print("ERROR: Unexpected error: Could not connect to MySQL instance.")
    #print(e)
    sys.exit(1)

try:
    with connection.cursor() as cursor:
        # Get the seller's user ID from the command-line arguments
        if len(sys.argv) > 1:
            seller_user_id = int(sys.argv[1])
        else:
            print("Error: User ID not provided.")
            sys.exit(1)
        
        # Fetch the preferred category of the seller
        cursor.execute(
            "SELECT preferred_category FROM Sellers WHERE user_id = %s",
            (seller_user_id,)
        )
        preferred_category = cursor.fetchone()[0]

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
        
        # Get a list of all item IDs from the preferred category
        cursor.execute(
            "SELECT item_id FROM Items WHERE category_id = %s",
            (preferred_category,)
        )
        preferred_category_items = [row[0] for row in cursor.fetchall()]
        
        # Predict ratings for items from the preferred category
        predicted_ratings = {}
        for item_id in preferred_category_items:
            prediction = model.predict(seller_user_id, item_id)
            predicted_ratings[item_id] = prediction.est
        
        # Sort items by predicted rating (highest to lowest)
        sorted_predicted_items = sorted(predicted_ratings.items(), key=lambda x: x[1], reverse=True)
        
        # Display the top recommended items from the preferred category
        top_recommendations = [item_id for item_id, rating in sorted_predicted_items[:5]]
        recommended_items = []
        for item_id in top_recommendations:
            cursor.execute(
                "SELECT item_name FROM Items WHERE item_id = %s",
                (item_id,)
            )
            item_name = cursor.fetchone()[0]
            recommended_items.append(item_name)

        # Print recommendations as JSON
        recommendations_json = json.dumps(recommended_items)
        print(recommendations_json)

finally:
    connection.close()
