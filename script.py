from faker import Faker
import random

# Initialize the Faker instance
fake = Faker()

# Number of rows to generate for each table
num_rows = 100

# Define the table names
table_names = [
    'users', 'administrator', 'project', 'tag', 'task', 'post', 'assigned',
    'comment', 'file', 'invite', 'invite_notification', 'forum_notification',
    'project_notification', 'task_notification', 'comment_notification', 'project_participation',
    'project_task', 'project_tag', 'task_tag'
]

# Create a dictionary to map table names to their primary key column names
primary_key_columns = {
    'users': 'id',
    'administrator': 'id',
    'project': 'id',
    'tag': 'id',
    'task': 'id',
    'post': 'id',
    'assigned': ['user_id', 'task_id'],
    'comment': 'id',
    'file': 'id',
    'invite': 'id',
    'invite_notification': 'id',
    'forum_notification': 'id',
    'project_notification': 'id',
    'task_notification': 'id',
    'comment_notification': 'id',
    'project_participation': ['user_id', 'project_id'],
    'project_task': ['task_id', 'project_id'],
    'project_tag': ['tag_id', 'project_id'],
    'task_tag': ['tag_id', 'task_id']
}

# Generate and insert data into tables
with open('dummy_data_inserts.sql', 'w') as file:
    for table_name in table_names:

        file.write(f'-- Inserting data into the \'{table_name}\' table\n')

        for id in range(1, num_rows + 1):
            # Generate data based on the table name and its structure
            data = {}
            if table_name == 'users':
                username = fake.user_name()
                email = fake.email()
                password = fake.password()
                blocked = fake.boolean(chance_of_getting_true=10)  # 10% chance of being blocked
                file.write(f"INSERT INTO {table_name} (id, name, email, password, blocked) VALUES "
                        f"('{id}, {username}', '{email}', '{password}', {blocked});\n")
            elif table_name == 'administrator':
                name = fake.name()
                email = fake.email()
                password = fake.password()
                file.write(f"INSERT INTO {table_name} (id, name, email, password) VALUES "
                        f"('{id}, {name}', '{email}', '{password}');\n")
            elif table_name == 'project':
                title = fake.word()
                description = fake.sentence()
                is_archived = fake.boolean()
                creation = fake.date_time_between(start_date='-2y', end_date='now').strftime('%Y-%m-%d')
                deadline = fake.date_time_between(start_date='now', end_date='+1y').strftime('%Y-%m-%d')
                coordinator = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (id, title, description, is_archived, creation, deadline, coordinator) VALUES "
                        f"('{id}, {title}', '{description}', {is_archived}, '{creation}', '{deadline}', {coordinator});\n")
            elif table_name == 'tag':
                name = fake.word()
                file.write(f"INSERT INTO {table_name} (id, title) VALUES ('{id}, {name}');\n")
            elif table_name == 'task':
                title = fake.word()
                description = fake.sentence()
                status = random.choice(['open', 'canceled', 'closed'])
                starttime = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                endtime = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                deadline = fake.date_time_between(start_date='now', end_date='+1y').strftime('%Y-%m-%d')
                opened_user_id = fake.random_int(min=1, max=num_rows)
                closed_user_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (id, title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES "
                        f"('{id}, {title}', '{description}', '{status}', '{starttime}', '{endtime}', '{deadline}', {opened_user_id}, {closed_user_id});\n")
            elif table_name == 'post':
                content = fake.text(max_nb_chars=1000)
                submit_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                last_edited = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                user_id = fake.random_int(min=1, max=num_rows)
                project_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (id, content, submit_date, last_edited, user_id, project_id) VALUES "
                        f"('{id}, {content}', '{submit_date}', '{last_edited}', {user_id}, {project_id});\n")
            elif table_name == 'assigned':
                user_id = fake.random_int(min=1, max=num_rows)
                task_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (user_id, task_id) VALUES ({user_id}, {task_id});\n")
            elif table_name == 'comment':
                content = fake.text(max_nb_chars=1000)
                submit_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                last_edited = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                task_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (id, content, submit_date, last_edited, task_id, user_id) VALUES "
                        f"('{id}, {content}', '{submit_date}', '{last_edited}', {task_id}, {user_id});\n")
            elif table_name == 'file':
                name = fake.word()
                project_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (id, name, project_id) VALUES ('{id}, {name}', {project_id});\n")
            elif table_name == 'invite':
                email = fake.email()
                invite_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                user_id = fake.random_int(min=1, max=num_rows)
                project_id = fake.random_int(min=1, max=num_rows)
                accepted = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, email, invite_date, user_id, project_id, accepted) VALUES "
                        f"('{id}, '{email}', '{invite_date}', {user_id}, {project_id}, {accepted});\n")
            elif table_name == 'invite_notification':
                description = fake.sentence()
                notification_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                invite_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                seen = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, description, notification_date, invite_id, user_id, seen) VALUES "
                        f"('{id}, {description}', '{notification_date}', {invite_id}, {user_id}, {seen});\n")
            elif table_name == 'forum_notification':
                description = fake.sentence()
                notification_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                post_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                seen = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, description, notification_date, post_id, user_id, seen) VALUES "
                        f"('{id}, {description}', '{notification_date}', {post_id}, {user_id}, {seen});\n")
            elif table_name == 'project_notification':
                description = fake.sentence()
                notification_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                project_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                seen = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, description, notification_date, project_id, user_id, seen) VALUES "
                        f"('{id}, {description}', '{notification_date}', {project_id}, {user_id}, {seen});\n")
            elif table_name == 'task_notification':
                description = fake.sentence()
                notification_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                task_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                seen = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, description, notification_date, task_id, user_id, seen) VALUES "
                        f"('{id}, {description}', '{notification_date}', {task_id}, {user_id}, {seen});\n")
            elif table_name == 'comment_notification':
                description = fake.sentence()
                notification_date = fake.date_time_between(start_date='-1y', end_date='now').strftime('%Y-%m-%d')
                comment_id = fake.random_int(min=1, max=num_rows)
                user_id = fake.random_int(min=1, max=num_rows)
                seen = fake.boolean()
                file.write(f"INSERT INTO {table_name} (id, description, notification_date, comment_id, user_id, seen) VALUES "
                        f"('{id}, {description}', '{notification_date}', {comment_id}, {user_id}, {seen});\n")
            elif table_name == 'project_participation':
                user_id = fake.random_int(min=1, max=num_rows)
                project_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (user_id, project_id) VALUES ({user_id}, {project_id});\n")
            elif table_name == 'project_task':
                task_id = fake.random_int(min=1, max=num_rows)
                project_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (task_id, project_id) VALUES ({task_id}, {project_id});\n")
            elif table_name == 'project_tag':
                tag_id = fake.random_int(min=1, max=num_rows)
                project_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (tag_id, project_id) VALUES ({tag_id}, {project_id});\n")
            elif table_name == 'task_tag':
                tag_id = fake.random_int(min=1, max=num_rows)
                task_id = fake.random_int(min=1, max=num_rows)
                file.write(f"INSERT INTO {table_name} (tag_id, task_id) VALUES ({tag_id}, {task_id});\n")
                
print("Realistic-looking dummy data INSERT statements have been written to 'dummy_data_inserts.sql'")
