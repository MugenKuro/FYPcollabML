import os
import sys
lib_path = "/home/.local/lib/python3.9/site-packages"
sys.path.append(lib_path)

from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
import pandas as pd
import pymysql
import json
# import mysql.connector


rec_size = 4

item_id = int(sys.argv[1])
script_dir = os.path.dirname(os.path.abspath(__file__))

# Database connection parameters
db_host = 'icloth.mysql.database.azure.com'
db_user = 'iclothfyp'
db_password = 'Fyp123!@#'
db_name = 'eComDB'
db_ssl = os.path.join(script_dir, '../SSL_cert/DigiCertGlobalRootCA.crt.pem')
try:
    connection = pymysql.connect(
        host=db_host,
        user=db_user,
        password=db_password,
        db=db_name,
        ssl_ca=db_ssl
    )
except pymysql.MySQLError as err:
    sys.exit(1)

# host = "localhost"
# port = 3306
# database = "ecomdb"
# user = "root"
# password = "password"

# try:
#     connection = mysql.connector.connect(
#         host=host,
#         port=port,
#         database=database,
#         user=user,
#         password=password
#     )
# except mysql.connector.Error as err:
#     sys.exit(1)


cursor = connection.cursor()
# cursor1 = connection.cursor()

# item_id, seller_id, item_name, category_id
cursor.execute("SELECT * FROM ITEMS")
items = cursor.fetchall()
# cursor1.execute("SELECT * FROM ITEMRATINGS")
# items_rating = cursor1.fetchall()

# Load and preprocess your data (items and items_rating tables)
items_df = pd.DataFrame(items, columns=[i[0] for i in cursor.description])
# ratings_df = pd.DataFrame(items_rating, columns=[
#                           i[0] for i in cursor1.description])

vectorizer = TfidfVectorizer(stop_words='english')
item_vectors = vectorizer.fit_transform(items_df['description'])
item_similarity_matrix = cosine_similarity(item_vectors)
# print(items_df)


def recommend_similar_items(item_id, top_n=rec_size):
    # Get the index of the item in the items_df DataFrame
    original_item_index = items_df[items_df['item_id'] == item_id].index[0]

    # Get the cosine similarity scores for the given item with all other items.
    item_similarity_scores = item_similarity_matrix[original_item_index]

    # Sort the similarity scores in descending order.
    sorted_item_similarity_scores = sorted(enumerate(item_similarity_scores),
                                           key=lambda x: x[1], reverse=True)

    # Get the IDs of the top N most similar items.
    top_n_similar_item_ids = [
        items_df.iloc[item_index]['item_id'] for item_index, similarity_score in sorted_item_similarity_scores[:top_n]]

    return top_n_similar_item_ids


# Call the function with your item_id
top_n_similar_item_ids = recommend_similar_items(item_id)

# The resulting top_n_similar_item_ids should now match your original item_id.


top_n_similar_item_ids = recommend_similar_items(item_id)
if item_id in top_n_similar_item_ids:
    top_n_similar_item_ids.remove(item_id)
else:
    top_n_similar_item_ids = top_n_similar_item_ids[:-1]
top_recommendations = [int(item_id) for item_id in top_n_similar_item_ids]
recommendations_json = json.dumps(top_recommendations)

print(recommendations_json)

connection.close()