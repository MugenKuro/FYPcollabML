import sys
import os
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
    print("SUCCESS: Connection to Remote MySQL instance succeeded")
except pymysql.MySQLError as e:
    print("ERROR: Unexpected error: Could not connect to MySQL instance.")
    print(e)
    sys.exit(1)

try:
    with connection.cursor() as cursor:
        customer_user_id = 1  # Replace with the actual customer's user ID
        
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
        
        # Build a train set and a test set
        trainset, testset = train_test_split(dataset, test_size=0.2)
        
        # Build and train an SVD (Singular Value Decomposition) model
        model = SVD()
        model.fit(trainset)
        
        # Get a list of all item IDs
        all_item_ids = list(set(df['item_id'].unique()))
        
        # Predict ratings for items for the customer
        predicted_ratings = {}
        for item_id in all_item_ids:
            prediction = model.predict(customer_user_id, item_id)
            predicted_ratings[item_id] = prediction.est
        
        # Sort items by predicted rating (highest to lowest)
        sorted_predicted_items = sorted(predicted_ratings.items(), key=lambda x: x[1], reverse=True)
        
        # Get the top 5 recommended item IDs
        top_recommendations = [item_id for item_id, rating in sorted_predicted_items[:5]]
        
        # Convert item IDs to regular integers
        top_recommendations = [int(item_id) for item_id in top_recommendations]
        
        # Convert the top 5 recommendations to JSON
        recommendations_json = json.dumps(top_recommendations)
        
        # Print the JSON output
        print(recommendations_json)

finally:
    connection.close()
