import json
import sys
import mysql.connector
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity


rec_size = 4

item_id = int(sys.argv[1])

host = "icloth.mysql.database.azure.com"
port = 3306
database = "ecomdb"
user = "iclothfyp"
password = "Fyp123!@#"

# host = "localhost"
# port = 3306
# database = "ecomdb"
# user = "root"
# password = "password"
try:
    connection = mysql.connector.connect(
        host=host, port=port, database=database, user=user, password=password)
except mysql.connector.Error as err:
    print("Something went wrong: {}".format(err))
    exit()

cursor = connection.cursor()
cursor1 = connection.cursor()

# item_id, seller_id, item_name, category_id
cursor.execute("SELECT * FROM ITEMS")
items = cursor.fetchall()
cursor1.execute("SELECT * FROM ITEMRATINGS")
items_rating = cursor1.fetchall()

# Load and preprocess your data (items and items_rating tables)
items_df = pd.DataFrame(items, columns=[i[0] for i in cursor.description])
ratings_df = pd.DataFrame(items_rating, columns=[
                          i[0] for i in cursor1.description])

vectorizer = TfidfVectorizer(stop_words='english')
item_vectors = vectorizer.fit_transform(items_df['description'])
item_similarity_matrix = cosine_similarity(item_vectors)


def recommend_similar_items(item_id, top_n=rec_size):
    # Get the cosine similarity scores for the given item with all other items.
    item_similarity_scores = item_similarity_matrix[item_id]

    # Sort the similarity scores in descending order.
    sorted_item_similarity_scores = sorted(enumerate(item_similarity_scores),
                                           key=lambda x: x[1], reverse=True)

    # Get the IDs of the top N most similar items.
    top_n_similar_item_ids = [
        item_id for item_id, similarity_score in sorted_item_similarity_scores[:top_n]]

    return top_n_similar_item_ids

top_n_similar_item_ids = recommend_similar_items(item_id)
if item_id in top_n_similar_item_ids:
    top_n_similar_item_ids.remove(item_id)
else:
    top_n_similar_item_ids = top_n_similar_item_ids[:-1]
top_recommendations = [int(item_id) for item_id in top_n_similar_item_ids]
recommendations_json = json.dumps(top_recommendations)

print(recommendations_json)

connection.close()
