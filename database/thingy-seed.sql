-- SCHEMA OPERATIONS
DROP SCHEMA IF EXISTS lbaw2353 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2353;
SET search_path TO lbaw2353;

-- DROP EXISTING TABLES
DROP TABLE IF EXISTS lbaw2353.users CASCADE;
DROP TABLE IF EXISTS lbaw2353.projects CASCADE;
DROP TABLE IF EXISTS lbaw2353.tags CASCADE;
DROP TABLE IF EXISTS lbaw2353.tasks CASCADE;
DROP TABLE IF EXISTS lbaw2353.posts CASCADE;
DROP TABLE IF EXISTS lbaw2353.task_user CASCADE;
DROP TABLE IF EXISTS lbaw2353.comments CASCADE;
DROP TABLE IF EXISTS lbaw2353.files CASCADE;
DROP TABLE IF EXISTS lbaw2353.invites CASCADE;
DROP TABLE IF EXISTS lbaw2353.invite_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.forum_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.task_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.comment_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_user CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_task CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_tag CASCADE;
DROP TABLE IF EXISTS lbaw2353.tag_task CASCADE;

DROP TYPE IF EXISTS lbaw2353.task_status; 

-- CREATE TYPES 
CREATE TYPE lbaw2353.task_status AS ENUM ('open', 'canceled', 'closed');

-- CREATE TABLES

-- 1
CREATE TABLE lbaw2353.users(
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_blocked BOOLEAN NOT NULL DEFAULT FALSE,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    remember_token VARCHAR(100)
);

--0 CHECK IMAGE
CREATE TABLE lbaw2353.projects (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    is_archived BOOLEAN DEFAULT FALSE,
    creation TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    deadline TIMESTAMP WITH TIME ZONE CHECK (deadline IS NULL OR (creation < deadline)),
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);
--1 
CREATE TABLE lbaw2353.tags(
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL
);
-- 0 starttime default?
CREATE TABLE lbaw2353.tasks (
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    description VARCHAR(100),
    status lbaw2353.task_status NOT NULL DEFAULT 'open',
    starttime TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    endtime TIMESTAMP WITH TIME ZONE ,
    deadline TIMESTAMP WITH TIME ZONE CHECK (deadline IS NULL OR (starttime < deadline)),
    opened_user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL,
    closed_user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL
);
--1 (default not in schema)
CREATE TABLE lbaw2353.posts(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    submit_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    last_edited TIMESTAMP WITH TIME ZONE DEFAULT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);
--1 
CREATE TABLE lbaw2353.task_user(
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE, 
    task_id INTEGER REFERENCES lbaw2353.tasks(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (user_id,task_id)
);
--1 (DEFAULTS TO SEE)
CREATE TABLE lbaw2353.comments(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    submit_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    last_edited TIMESTAMP WITH TIME ZONE DEFAULT NULL,
    task_id INTEGER REFERENCES lbaw2353.tasks(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL
);
--1
CREATE TABLE lbaw2353.files(
    id SERIAL PRIMARY KEY,
    name VARCHAR(1000) NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    UNIQUE(name,project_id)
);

CREATE TABLE lbaw2353.invites (
    id SERIAL PRIMARY KEY,
    email VARCHAR(1000) NOT NULL,
    invite_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    accepted BOOLEAN NOT NULL DEFAULT FALSE,
    UNIQUE (email, project_id)
);

CREATE TABLE lbaw2353.invite_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    invite_id INTEGER REFERENCES lbaw2353.invites(id) ON UPDATE CASCADE NOT NULL UNIQUE, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.forum_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL ,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    post_id INTEGER REFERENCES lbaw2353.posts(id) ON UPDATE CASCADE NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.project_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.task_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    task_id INTEGER REFERENCES lbaw2353.tasks(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.comment_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    comment_id INTEGER REFERENCES lbaw2353.comments(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.project_user (
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE, 
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (user_id, project_id)
);
CREATE TABLE lbaw2353.project_task(
    task_id INTEGER REFERENCES lbaw2353.tasks(id) ON UPDATE CASCADE ON DELETE CASCADE,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    PRIMARY KEY(task_id)
);
--1
CREATE TABLE lbaw2353.project_tag(
    tag_id INTEGER REFERENCES lbaw2353.tags(id) ON UPDATE CASCADE ON DELETE CASCADE,
    project_id INTEGER REFERENCES lbaw2353.projects(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    PRIMARY KEY(tag_id)
);
--1
CREATE TABLE lbaw2353.tag_task(
    tag_id INTEGER REFERENCES lbaw2353.tags(id) ON UPDATE CASCADE ON DELETE CASCADE,
    task_id INTEGER REFERENCES lbaw2353.tasks(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (tag_id,task_id)
);

--------------------------------------------------------
-- Performance Indexes 
--------------------------------------------------------

CREATE INDEX comment_taks ON lbaw2353.comments USING hash (task_id);

CREATE INDEX tasks_in_project ON lbaw2353.project_task USING hash (project_id);

CREATE INDEX task_deadline ON lbaw2353.tasks USING btree (deadline);

--------------------------------------------------------
-- Full-text Search Indexes
--------------------------------------------------------

ALTER TABLE lbaw2353.users
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('portuguese', NEW.name), 'A') ||
            setweight(to_tsvector('portuguese', NEW.email), 'B') 
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name OR NEW.email <> OLD.email) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('portuguese', NEW.name), 'A') ||
                setweight(to_tsvector('portuguese', NEW.email), 'B') 
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
BEFORE INSERT OR UPDATE ON lbaw2353.users
FOR EACH ROW
EXECUTE PROCEDURE user_search_update();

CREATE INDEX search_user ON lbaw2353.users USING GIN (tsvectors);

ALTER TABLE lbaw2353.files
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION file_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = to_tsvector('portuguese', NEW.name);
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name) THEN
            NEW.tsvectors = to_tsvector('portuguese', NEW.name);
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER file_search_update
BEFORE INSERT OR UPDATE ON files
FOR EACH ROW
EXECUTE PROCEDURE file_search_update();

CREATE INDEX search_file ON files USING GIN (tsvectors);

ALTER TABLE lbaw2353.projects
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION project_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('portuguese', NEW.title), 'A') ||
            setweight(to_tsvector('portuguese', NEW.description), 'B') 
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
            NEW.tsvectors = (
            setweight(to_tsvector('portuguese', NEW.title), 'A') ||
            setweight(to_tsvector('portuguese', NEW.description), 'B') 
        );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER project_search_update
BEFORE INSERT OR UPDATE ON lbaw2353.projects
FOR EACH ROW
EXECUTE PROCEDURE project_search_update();

CREATE INDEX search_project ON lbaw2353.projects USING GIN (tsvectors);

ALTER TABLE lbaw2353.tags
ADD COLUMN tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION tag_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = to_tsvector('portuguese', NEW.title);
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.title <> OLD.title) THEN
            NEW.tsvectors = to_tsvector('portuguese', NEW.title);
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER tag_search_update
BEFORE INSERT OR UPDATE ON tags
FOR EACH ROW
EXECUTE PROCEDURE tag_search_update();

CREATE INDEX search_user_tag ON tags USING GIN (tsvectors);

--------------------------------------------------------
-- Triggers
--------------------------------------------------------


/*-When sending an invitation from a projects to a user if an invitation from the same projects to the same email already exist then,
the value of the invite_date should be changed to current date and the row should not be inserted
*/
/*The projects user_id can only send an invitation to the same user each 10 minutes*/

CREATE OR REPLACE FUNCTION update_invitation_date() RETURNS TRIGGER AS 
$BODY$
DECLARE
    past_time TIMESTAMP;
    time_difference DOUBLE PRECISION; -- Define time_difference variable
BEGIN
    IF EXISTS (SELECT 1 FROM lbaw2353.invites WHERE email = NEW.email AND project_id = NEW.project_id) THEN
		past_time := (  
            SELECT invite_date 
		    FROM invites
		    WHERE email = NEW.email AND project_id = NEW.project_id
        );
		
    	time_difference := EXTRACT(EPOCH FROM NOW()) - EXTRACT(EPOCH FROM past_time);
	
    	IF time_difference < 600.0 THEN
     	   RAISE EXCEPTION 'You have already sent an invite in the past 10 minutes';
    	ELSE
			DELETE FROM lbaw2353.invites WHERE email = NEW.email;
    		RETURN NEW;
    	END IF;
	ELSE
      RETURN NEW;
    END IF;
END 
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER send_invitation
BEFORE INSERT ON lbaw2353.invites
FOR EACH ROW
EXECUTE FUNCTION update_invitation_date();


/* -When a comments is send, a notification should be created for all the users task_user to the tasks*/

CREATE OR REPLACE FUNCTION send_comment_notification()
RETURNS TRIGGER AS $BODY$
DECLARE
    task_id_ INTEGER;
BEGIN
     task_id_:=(SELECT id FROM lbaw2353.tasks WHERE id in (SELECT task_id FROM lbaw2353.comments WHERE id = NEW."id"));
     

    
    INSERT INTO lbaw2353.comment_notification (description, notification_date, comment_id, user_id)
    SELECT
        'New comment on task ' || NEW.content,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.task_user
    WHERE task_id = task_id_;    

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER send_comment_notification_trigger
AFTER INSERT ON lbaw2353.comments
FOR EACH ROW
EXECUTE FUNCTION send_comment_notification();





/*-When a posts is send , a notification should be created for all the users that participate in the projects*/

CREATE OR REPLACE FUNCTION send_forum_notification()
RETURNS TRIGGER AS $BODY$
DECLARE
    proj_id INTEGER;
BEGIN

    proj_id:=(SELECT id FROM lbaw2353.projects WHERE id in (SELECT project_id FROM lbaw2353.posts WHERE id = NEW."id"));

    INSERT INTO lbaw2353.forum_notification (description, notification_date, post_id, user_id)
    SELECT
        'New post in project ' || NEW."content",
        NOW(),
        NEW."id",
        user_id
    FROM lbaw2353.project_user
    WHERE project_id = proj_id;

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER send_forum_notification_trigger
AFTER INSERT ON lbaw2353.posts
FOR EACH ROW
EXECUTE FUNCTION send_forum_notification();



/*-When the status of a tasks is changed a notification should be created for all the users task_user to a tasks*/
CREATE OR REPLACE FUNCTION send_task_state_notification()
RETURNS TRIGGER AS $BODY$
BEGIN
    INSERT INTO lbaw2353.task_notification (description, notification_date, task_id, user_id)
    SELECT
        'task state changed to ' || NEW.status,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.task_user
    WHERE task_id = NEW.id;

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER task_state_notification_trigger
AFTER UPDATE ON lbaw2353.tasks
FOR EACH ROW
WHEN (NEW.status <> OLD.status)
EXECUTE FUNCTION send_task_state_notification();











/*-When the projects state is changed a notification should be created for all the users in the projects*/

CREATE OR REPLACE FUNCTION send_project_state_notification()
RETURNS TRIGGER AS $BODY$
BEGIN
  
    INSERT INTO lbaw2353.project_notification (description, notification_date, project_id, user_id)
    SELECT
        'project state changed to ' || NEW.is_archived,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.project_user
    WHERE project_id = NEW.id;

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER project_state_notification_trigger
AFTER UPDATE ON lbaw2353.projects
FOR EACH ROW
WHEN (NEW.is_archived <> OLD.is_archived)
EXECUTE FUNCTION send_project_state_notification();




/*-When a posts is edited it's lastedited attribute should be updated to the current date*/
CREATE OR REPLACE FUNCTION update_last_edit_post_date()
RETURNS TRIGGER AS $BODY$
BEGIN
 
    NEW.last_edited := NOW();

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER edit_post_trigger
BEFORE UPDATE ON lbaw2353.posts
FOR EACH ROW
WHEN (NEW.content <> OLD.content)
EXECUTE FUNCTION update_last_edit_post_date();


/*-When a comments is edited it's lastedited attribute should be updated to the current date*/
CREATE OR REPLACE FUNCTION update_last_edit_comment_date()
RETURNS TRIGGER AS $BODY$
BEGIN

    NEW.last_edited := NOW();

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER edit_comment_trigger
BEFORE UPDATE ON lbaw2353.comments
FOR EACH ROW
WHEN (NEW.content <> OLD.content)
EXECUTE FUNCTION update_last_edit_comment_date();



/*-When the state of a tasks is changed to closed then the end attribute should change to the current date*/
CREATE OR REPLACE FUNCTION update_task_end_date()
RETURNS TRIGGER AS $BODY$
BEGIN

    NEW.endtime := NOW();

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER finalize_task_trigger
BEFORE UPDATE ON lbaw2353.tasks
FOR EACH ROW
WHEN (NEW.status <> OLD.status AND NEW.status = 'closed')
EXECUTE FUNCTION update_task_end_date();

/*Only a user who is part of the projects's team can be task_user as the projects user_id for that projects*/

CREATE OR REPLACE FUNCTION check_for_coordinator_in_project()
RETURNS TRIGGER AS $BODY$
BEGIN
    IF NEW.user_id NOT IN (SELECT user_id FROM lbaw2353.project_user WHERE project_id = NEW.id) THEN
        RAISE EXCEPTION 'Only a user who is part of the project''s team can be assigned as the project user_id.';
    END IF;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_assignment_trigger
BEFORE UPDATE ON lbaw2353.projects
FOR EACH ROW
WHEN (NEW.user_id <> OLD.user_id) 
EXECUTE FUNCTION check_for_coordinator_in_project();

/*Only projects coordinators can invites users to join their projects*/

CREATE OR REPLACE FUNCTION check_if_coordinator_send_invitation()
RETURNS TRIGGER AS $BODY$
BEGIN
    IF NEW.user_id NOT IN (SELECT user_id FROM lbaw2353.projects WHERE id = NEW.project_id) THEN
        RAISE EXCEPTION 'Only project coordinators can invite users to join their project.';
    END IF;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER coordinator_send_invitation_trigger
BEFORE INSERT ON lbaw2353.invites
FOR EACH ROW
EXECUTE FUNCTION check_if_coordinator_send_invitation();


/*Each tasks can only be marked as completed by users that are task_user to the tasks or the projects user_id*/

CREATE OR REPLACE FUNCTION check_who_closed_task()
RETURNS TRIGGER AS $BODY$
BEGIN
    IF  NEW.closed_user_id NOT IN (SELECT user_id FROM lbaw2353.task_user WHERE task_id = NEW.id) AND
        NEW.closed_user_id <> (SELECT user_id FROM lbaw2353.projects WHERE id = (SELECT project_id FROM lbaw2353.project_task WHERE task_id = NEW.id)) THEN
        RAISE EXCEPTION 'Each task can only be marked as completed by users that are assigned to the task or the project user_id.';
    END IF;

    RETURN NEW;
END
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER task_closed_trigger
BEFORE UPDATE ON lbaw2353.tasks
FOR EACH ROW
WHEN (NEW.status <> OLD.status AND NEW.status = 'closed') 
EXECUTE FUNCTION check_who_closed_task();

/*Admins should not be able to participate in a project*/

CREATE OR REPLACE FUNCTION check_user()
    RETURNS TRIGGER AS $BODY$
BEGIN
    IF  NEW.user_id IN (SELECT id FROM lbaw2353.users WHERE is_admin = TRUE) THEN
    RAISE EXCEPTION 'Admins cannot participate in projects';
    END IF;

    RETURN NEW;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER add_user_to_project
    BEFORE INSERT ON lbaw2353.project_user
    FOR EACH ROW
EXECUTE FUNCTION check_user();


/*Tasks could only have tags from project*/

CREATE OR REPLACE FUNCTION tag_task_from_the_same_project()
    RETURNS TRIGGER AS $BODY$
BEGIN
    IF  NEW.tag_id in(SELECT project_tag.tag_id FROM lbaw2353.project_tag JOIN lbaw2353.project_task on project_tag.project_id = project_task.project_id)THEN
        RETURN NEW;
    ELSE
    RAISE EXCEPTION 'Only tags from the project can be added to the task';
    END IF;


END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER add_tag_to_task
    BEFORE INSERT ON lbaw2353.tag_task
    FOR EACH ROW
EXECUTE FUNCTION tag_task_from_the_same_project();

/*Only users who participate in a project can be assigned to the project*/
CREATE OR REPLACE FUNCTION user_must_belong_to_project()
    RETURNS TRIGGER AS $BODY$
BEGIN
    IF  NEW.user_id in(SELECT project_user.user_id FROM lbaw2353.project_user JOIN lbaw2353.project_task on project_user.project_id = project_task.project_id)THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'Only users from the project can be assigned';
    END IF;


END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER assign_user
    BEFORE INSERT ON lbaw2353.task_user
    FOR EACH ROW
EXECUTE FUNCTION user_must_belong_to_project();


--------------------------------------------------------
-- POPULATE TABLES
--------------------------------------------------------z

-- Inserting data into the 'users' table
INSERT INTO users (name, email, password, is_blocked) VALUES ('william17', 'nturner@example.org', ')53J**8Tjv', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('randalldaniel', 'loriduran@example.net', '+ybPN5ytO3', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('tmcmahon', 'vperez@example.org', '&)^5dDswBi', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('kimberlyhayes', 'wilcoxanita@example.net', 'B9@ZQUNi^_', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('perrymichael', 'ichurch@example.net', '*j69cZgl5c', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('tzimmerman', 'garciapatricia@example.org', 'B!GS6Z)xP%', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('richardsonedward', 'freilly@example.net', 'I9YK5Nku%@', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('steven10', 'scottandre@example.com', 'PM@34SXyTs', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ('taylorcarlos', 'susan86@example.com', '0YqZWwfI(6', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'matthew09', 'sweeneyangel@example.com', 'Jpk5BfWb^*', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'franklinanthony', 'deanrobinson@example.net', 'Oa7HGoB9c+', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'wzimmerman', 'nicolefoster@example.com', 'PdFg2Dmf$s', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'carolwagner', 'tmendoza@example.org', '#OIaXCu_c6', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'michaelbenitez', 'lhogan@example.net', 'q0^T7nKoj5', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'cbarrett', 'ortegadonald@example.org', 'F_+7sYDl7f', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'dbailey', 'browndaniel@example.net', ')^2IQ@bh8x', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'ramirezjacob', 'cbuck@example.org', '(05tBh+3$J', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'rwilliams', 'jeremy24@example.com', 'z1ZGca8a^N', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'zmorrison', 'kmorris@example.net', 'uC3EdFqF#8', False);
INSERT INTO users (name, email, password, is_blocked) VALUES ( 'hortonkendra', 'joshua28@example.com', '9)5BmJJuBt', False);
-- Inserting data into the 'projects' table
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('when', 'Tend condition physical detail listen explain.', True, '2023-03-30', '2024-06-14', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('population', 'North I writer actually arm heart protect.', False, '2022-12-31', '2024-06-29', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('question', 'Report lay quickly out manage line summer start.', True, '2022-12-11', '2024-06-28', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('leg', 'Ask environment American glass lose sing.', True, '2022-01-22', '2024-06-26', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('defense', 'Look share network difference.', False, '2022-02-05', '2024-09-21', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('notice', 'Call no ok try.', False, '2023-02-07', '2024-03-13', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('you', 'Range recognize institution trade argue.', True, '2023-02-04', '2024-10-18', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('her', 'Figure song lay to teach respond.', False, '2022-01-15', '2024-02-20', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ('court', 'Group under red more leave green.', True, '2022-06-04', '2024-05-07', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'reflect', 'Case appear Democrat look former suddenly others many.', True, '2022-08-30', '2024-09-22', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'technology', 'Commercial miss statement.', False, '2021-12-25', '2024-01-26', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'yes', 'Beautiful sure forget number computer administration oil.', False, '2023-02-20', '2024-07-22', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'similar', 'Citizen order put.', False, '2023-05-01', '2024-05-16', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'get', 'Week low professor part Republican image your always.', True, '2023-08-12', '2023-12-06', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'food', 'Conference world so president job.', True, '2023-10-12', '2024-10-13', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'meeting', 'Leave rate style.', True, '2021-12-12', '2023-12-03', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'debate', 'Include himself accept house public.', True, '2023-03-28', '2024-07-03', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'author', 'Role fly issue friend short law.', False, '2022-08-09', '2024-02-21', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'development', 'Attorney our close serve outside hold shake.', False, '2022-06-23', '2024-06-06', 10);
INSERT INTO projects (title, description, is_archived, creation, deadline, user_id) VALUES ( 'rule', 'Finally clearly child them word.', False, '2023-05-30', '2024-03-05', 10);
-- Inserting data into the 'tags' table
INSERT INTO tags (title) VALUES ('eye');
INSERT INTO tags (title) VALUES ('chair');
INSERT INTO tags (title) VALUES ('various');
INSERT INTO tags (title) VALUES ('down');
INSERT INTO tags (title) VALUES ('five');
INSERT INTO tags (title) VALUES ('along');
INSERT INTO tags (title) VALUES ('reduce');
INSERT INTO tags (title) VALUES ('member');
INSERT INTO tags (title) VALUES ('least');
INSERT INTO tags (title) VALUES ( 'two');
INSERT INTO tags (title) VALUES ( 'which');
INSERT INTO tags (title) VALUES ( 'it');
INSERT INTO tags (title) VALUES ( 'into');
INSERT INTO tags (title) VALUES ( 'bed');
INSERT INTO tags (title) VALUES ( 'say');
INSERT INTO tags (title) VALUES ( 'current');
INSERT INTO tags (title) VALUES ( 'sign');
INSERT INTO tags (title) VALUES ( 'hit');
INSERT INTO tags (title) VALUES ( 'develop');
INSERT INTO tags (title) VALUES ( 'cold');
-- Inserting data into the 'tasks' table
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('speak', 'Issue close eye music others forward.', 'canceled', '2022-10-31', '2023-04-11', '2024-07-22', 18, 8);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('race', 'See soon onto senior prepare fine.', 'canceled', '2023-08-24', '2023-05-23', '2024-06-10', 9, 17);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('play', 'Three floor country prove bar management.', 'closed', '2023-04-03', '2022-12-11', '2024-07-14', 8, 4);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('sort', 'Fund make learn.', 'closed', '2022-12-19', '2023-05-25', '2023-12-10', 20, 2);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('human', 'Contain each indicate blood wind while edge.', 'open', '2023-09-05', '2022-12-28', '2024-09-11', 2, 19);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('watch', 'Event performance easy nation would.', 'canceled', '2023-06-23', '2023-01-28', '2024-08-19', 15, 10);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('affect', 'Paper happy in a.', 'canceled', '2022-11-25', '2022-12-31', '2024-01-04', 17, 4);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('owner', 'Bank picture soon.', 'closed', '2023-05-25', '2023-09-30', '2023-12-28', 10, 14);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ('appear', 'Anything be outside myself customer accept war also.', 'closed', '2023-05-02', '2023-05-01', '2024-05-16', 9, 9);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'region', 'Story color very in enjoy including case.', 'open', '2023-02-02', '2022-12-03', '2024-01-11', 9, 5);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'order', 'Lawyer believe reach night.', 'canceled', '2023-01-23', '2023-06-29', '2023-12-26', 7, 16);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'material', 'Building thus condition administration house prevent.', 'closed', '2022-12-09', '2022-11-17', '2023-11-10', 18, 5);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'large', 'Arrive son machine national.', 'open', '2023-05-08', '2023-03-24', '2023-12-27', 14, 9);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'under', 'Still boy work difficult focus people student.', 'closed', '2023-05-16', '2023-04-25', '2024-08-16', 2, 4);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'run', 'Laugh five agent positive.', 'canceled', '2023-01-30', '2023-09-22', '2024-03-04', 6, 1);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'oil', 'Notice such arrive blue trade keep.', 'open', '2023-05-10', '2023-08-10', '2024-06-25', 2, 14);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'room', 'Finally painting stock appear stage sport source that.', 'canceled', '2023-01-23', '2023-09-11', '2023-12-19', 13, 6);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'degree', 'Daughter stay particularly him beat important ten president.', 'open', '2023-05-03', '2023-01-13', '2024-10-09', 10, 19);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'certain', 'Those option may fast chair off station.', 'closed', '2023-08-07', '2023-05-10', '2024-08-13', 10, 18);
INSERT INTO tasks (title, description, status, starttime, endtime, deadline, opened_user_id, closed_user_id) VALUES ( 'ago', 'Cell over process condition subject short interest.', 'closed', '2023-07-28', '2023-09-03', '2024-10-15', 8, 1);
-- Inserting data into the 'posts' table
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Good range amount but remain approach.', '2023-04-30', '2023-04-24', 12, 8);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('In reveal certain tough. Under act country loss spend last.', '2023-09-06', '2023-04-09', 3, 10);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Of everyone first tell. Concern activity protect quickly feeling.', '2022-12-09', '2022-11-01', 1, 15);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Happen have take instead color. Dream fast other against.', '2022-12-31', '2023-06-29', 1, 15);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Result possible race enough wonder step million. Home PM town yard take buy.', '2022-12-26', '2023-07-20', 15, 7);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Base eat go close. Parent walk do information. Teach knowledge mission open century the test.', '2023-04-02', '2023-03-10', 16, 4);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Day save of everything religious. Sort student nothing both. We speech the challenge out head even.', '2023-02-15', '2023-01-23', 14, 7);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Fall run stand director walk fight example. Democratic rest leave fear wind.', '2023-02-06', '2023-05-10', 18, 16);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Without base agency on maybe resource source tend. Claim talk stand reflect everything maybe.', '2023-10-02', '2023-01-06', 12, 12);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Head law house body who federal. Kind security two.', '2022-12-01', '2023-03-25', 15, 18);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Respond your effect measure tax. Phone according account. Defense policy commercial.', '2023-07-27', '2023-02-06', 8, 5);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Able PM grow drop during ready its. Tonight area foreign scene.', '2023-10-21', '2023-10-15', 17, 8);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Happen whatever she bad without least. Require use wish fine need system.', '2022-12-12', '2023-06-07', 16, 19);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Medical here heart reality house page. Employee character sport trouble mother whole.', '2022-12-26', '2023-04-16', 12, 2);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Commercial three moment. However prevent bring set technology.', '2022-11-13', '2022-11-21', 8, 2);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Interesting physical now good night. Woman find job us speak lot.', '2023-09-10', '2023-01-06', 16, 18);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Continue win only vote thing begin value include. Play style should magazine on.', '2023-04-12', '2023-07-30', 15, 8);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Out give beyond apply decision cost. Decision clear building structure true hold. Across wear meet.', '2022-12-19', '2023-09-13', 16, 4);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('General source red plan school. Minute senior suffer thought. Toward group plant.', '2023-09-15', '2023-03-23', 6, 10);
INSERT INTO posts (content, submit_date, last_edited, user_id, project_id) VALUES ('Oil direction boy late commercial age. Show personal prepare no day. Check capital itself.', '2023-04-03', '2023-09-26', 15, 19);
-- Inserting data into the 'task_user' table


-- Inserting data into the 'comments' table
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Middle character accept another push drug nice. Tend writer season manage word near pattern.', '2023-08-23', '2022-12-12', 12, 9);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Six also career happy. Sea throughout power listen tree.', '2023-06-23', '2023-02-18', 3, 18);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('After inside evidence skill hand difficult. Pattern plant assume many son.', '2023-06-16', '2023-02-08', 10, 6);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Word reality focus soldier. Help adult lay represent half couple.', '2023-07-06', '2023-07-20', 9, 18);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Production within matter foreign return bring. Value read range general.', '2023-10-17', '2023-05-15', 15, 9);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Employee per education majority manager heavy set computer. Reach recently name fund job.', '2023-07-30', '2023-09-07', 7, 9);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Lead four expert if spend. She traditional billion wind message event.', '2023-02-10', '2023-03-25', 7, 10);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('World account talk back back claim. Fly draw forward include picture.', '2023-01-13', '2023-02-12', 12, 1);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ('Enter right vote upon your involve. Simply certainly enter hand answer indeed entire.', '2023-01-28', '2023-06-02', 18, 10);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Media standard daughter professional. Rather I table quite left about remain home.', '2022-12-23', '2023-06-20', 4, 12);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Experience enough way else health each per.', '2022-11-03', '2023-06-01', 9, 14);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Dog large research instead. Develop carry himself send about to evidence perhaps.', '2022-12-02', '2023-02-04', 15, 2);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Trip south drop region late physical. Check risk decade worry standard will. Turn major west show.', '2022-11-26', '2023-08-27', 15, 8);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Of measure lead. Interesting ready best do suffer. Wish difference resource recent.', '2023-09-19', '2023-02-20', 13, 3);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'School study its ground everybody. Pick history control run. Foreign write town it half.', '2023-03-06', '2022-11-27', 18, 3);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Some space magazine instead wish enough. Research food over culture often government.', '2023-06-17', '2023-07-18', 3, 6);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Wife responsibility peace letter identify again. Really happy agency property other.', '2023-06-30', '2023-10-22', 16, 1);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Training concern instead.', '2023-06-27', '2023-08-11', 17, 15);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Out fill tree father him such property. Wear high or position change strategy.', '2023-10-02', '2022-12-25', 7, 18);
INSERT INTO comments (content, submit_date, last_edited, task_id, user_id) VALUES ( 'Her blue like law receive. Choice kid beautiful choice threat. Get section energy performance.', '2023-08-02', '2023-03-23', 5, 12);
-- Inserting data into the 'files' table
INSERT INTO files (name, project_id) VALUES ('today', 1);
INSERT INTO files (name, project_id) VALUES ('source', 14);
INSERT INTO files (name, project_id) VALUES ('worry', 7);
INSERT INTO files (name, project_id) VALUES ('home', 5);
INSERT INTO files (name, project_id) VALUES ('door', 11);
INSERT INTO files (name, project_id) VALUES ('hope', 8);
INSERT INTO files (name, project_id) VALUES ('last', 6);
INSERT INTO files (name, project_id) VALUES ('themselves', 2);
INSERT INTO files (name, project_id) VALUES ('tell', 18);
INSERT INTO files (name, project_id) VALUES ( 'stop', 15);
INSERT INTO files (name, project_id) VALUES ( 'word', 7);
INSERT INTO files (name, project_id) VALUES ( 'cover', 3);
INSERT INTO files (name, project_id) VALUES ( 'positive', 7);
INSERT INTO files (name, project_id) VALUES ( 'capital', 11);
INSERT INTO files (name, project_id) VALUES ( 'alone', 14);
INSERT INTO files (name, project_id) VALUES ( 'south', 19);
INSERT INTO files (name, project_id) VALUES ( 'magazine', 11);
INSERT INTO files (name, project_id) VALUES ( 'run', 17);
INSERT INTO files (name, project_id) VALUES ( 'bank', 11);
INSERT INTO files (name, project_id) VALUES ( 'tough', 8);
-- Inserting data into the 'invites' table
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('meredith24@example.com', '2023-06-23', 10, 13, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('vickie50@example.org', '2023-05-04', 10, 17, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('laneangela@example.net', '2023-02-26', 10, 14, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('therman@example.net', '2023-04-10', 10, 1, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('ksolomon@example.org', '2023-01-26', 10, 3, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ('martinstacey@example.com', '2023-01-11', 10, 6, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'qcarter@example.org', '2023-03-26', 10, 6, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'derekshields@example.com', '2023-05-04', 10, 2, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'taylorricky@example.com', '2023-01-27', 10, 20, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'robertarnold@example.org', '2023-09-04', 10, 8, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'mfowler@example.org', '2023-07-18', 10, 12, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'dorothy21@example.net', '2023-06-21', 10, 16, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'elizabeth32@example.org', '2023-06-15', 10, 12, True);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'micheal97@example.net', '2023-08-30', 10, 9, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'pughrebekah@example.net', '2023-08-13', 10, 19, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'tanya47@example.org', '2022-12-05', 10, 8, False);
INSERT INTO invites (email, invite_date, user_id, project_id, accepted) VALUES ( 'cathyperez@example.com', '2023-03-03', 10, 18, False);

-- Inserting data into the 'forum_notification' table
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Impact walk herself above score last.', '2023-09-09', 19, 17, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Once contain past guy recently.', '2022-11-07', 17, 11, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Nation safe read theory.', '2023-09-14', 9, 11, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Prepare police commercial.', '2022-12-31', 9, 20, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('System who candidate forward against.', '2023-09-09', 12, 16, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Hour left before serious bed by yard.', '2023-07-04', 11, 12, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Class certain board.', '2023-02-28', 7, 6, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Great manage administration argue how design technology opportunity.', '2023-07-20', 6, 4, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Actually clear main century including.', '2023-05-04', 3, 5, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('People personal head parent debate follow.', '2023-08-20', 14, 3, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Conference executive team catch hot.', '2023-05-21', 4, 4, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Yet evening player town door.', '2022-11-15', 9, 20, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Investment prove star report her participant.', '2023-07-23', 3, 14, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Until material something bad himself.', '2023-01-03', 15, 18, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Election time leave tax operation.', '2023-10-05', 4, 20, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Again own military outside then expect office.', '2023-02-13', 4, 13, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Not check pattern simply those information.', '2023-06-21', 3, 3, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Clearly newspaper prevent south training fine no.', '2023-04-04', 12, 9, False);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Rate stage let fear of community.', '2023-02-01', 8, 4, True);
INSERT INTO forum_notification (description, notification_date, post_id, user_id, seen) VALUES ('Capital smile week future.', '2023-05-24', 7, 5, True);
-- Inserting data into the 'project_notification' table
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Assume choice nor consider prove look give.', '2023-10-01', 5, 10, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Business necessary school tree reveal type.', '2023-09-24', 15, 19, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Meet move concern may everyone.', '2023-04-29', 9, 12, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Wish reveal check especially sell.', '2023-02-15', 16, 17, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Lawyer fill total event their these nothing.', '2023-03-25', 14, 6, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Source future left morning join its series.', '2023-01-07', 7, 20, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Blood of bar top more type.', '2023-03-24', 10, 3, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Any with certainly recently there art agent.', '2022-12-09', 19, 8, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ('Cover require keep down listen.', '2023-09-16', 9, 18, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Win budget beyond pay institution as.', '2023-08-11', 7, 5, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Little do save southern.', '2023-01-03', 17, 1, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Place summer back few ask thousand.', '2023-07-23', 17, 13, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Measure system worry for positive pay let close.', '2023-01-26', 14, 1, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Of green prove room.', '2023-09-25', 8, 4, False);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Take mouth half represent fight let best.', '2023-07-13', 19, 2, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Nothing whom walk player main father leave.', '2023-03-15', 20, 19, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Range field turn.', '2023-07-26', 19, 4, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Art short level per war.', '2023-08-21', 16, 1, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Direction yes somebody model own surface.', '2023-03-08', 1, 7, True);
INSERT INTO project_notification (description, notification_date, project_id, user_id, seen) VALUES ( 'Participant or its.', '2023-10-13', 9, 6, True);
-- Inserting data into the 'task_notification' table
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Our best purpose more agent.', '2023-01-04', 10, 1, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('task best both rather name.', '2023-06-12', 15, 17, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Kind picture change foreign policy.', '2023-07-25', 9, 5, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Become return thousand color east quite.', '2023-08-07', 20, 1, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Reduce hit government.', '2023-05-31', 9, 6, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Art project fight money carry chair.', '2022-12-10', 3, 1, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Behavior whom majority.', '2023-10-21', 14, 15, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Seek administration gun class worker consider role position.', '2022-12-08', 16, 4, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Suffer actually treatment easy cause.', '2023-01-26', 14, 2, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Gas hear serve live lose article fly.', '2023-09-05', 18, 9, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('You ready boy fact.', '2023-05-22', 7, 2, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Under next now family even usually heart.', '2023-04-05', 15, 18, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Bit recent Congress name cause various.', '2022-12-27', 19, 7, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Brother begin again read bill.', '2023-03-08', 2, 9, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('While people per prove mention close step financial.', '2023-02-20', 8, 18, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Condition take beat ask.', '2023-01-30', 2, 10, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Return travel training wind fly admit thousand wonder.', '2022-12-25', 1, 15, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Be city father degree design can.', '2023-04-03', 18, 16, False);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Fight effort husband save see.', '2022-11-23', 16, 7, True);
INSERT INTO task_notification (description, notification_date, task_id, user_id, seen) VALUES ('Whether forget admit up.', '2023-03-16', 3, 20, True);
-- Inserting data into the 'project_user' table
INSERT INTO project_user (user_id, project_id) VALUES (1, 1);
INSERT INTO project_user (user_id, project_id) VALUES (17, 13);
INSERT INTO project_user (user_id, project_id) VALUES (13, 5);
INSERT INTO project_user (user_id, project_id) VALUES (10, 3);
INSERT INTO project_user (user_id, project_id) VALUES (4, 4);
INSERT INTO project_user (user_id, project_id) VALUES (3, 8);
INSERT INTO project_user (user_id, project_id) VALUES (14, 4);
INSERT INTO project_user (user_id, project_id) VALUES (11, 2);
INSERT INTO project_user (user_id, project_id) VALUES (5, 6);
INSERT INTO project_user (user_id, project_id) VALUES (1, 2);
INSERT INTO project_user (user_id, project_id) VALUES (20, 14);
INSERT INTO project_user (user_id, project_id) VALUES (18, 7);
INSERT INTO project_user (user_id, project_id) VALUES (11, 15);
INSERT INTO project_user (user_id, project_id) VALUES (4, 10);
INSERT INTO project_user (user_id, project_id) VALUES (17, 18);
INSERT INTO project_user (user_id, project_id) VALUES (10, 9);
INSERT INTO project_user (user_id, project_id) VALUES (6, 5);
INSERT INTO project_user (user_id, project_id) VALUES (15, 19);
INSERT INTO project_user (user_id, project_id) VALUES (15, 10);
INSERT INTO project_user (user_id, project_id) VALUES (7, 13);
-- Inserting data into the 'project_task' table
INSERT INTO project_task (task_id, project_id) VALUES (1, 1);
INSERT INTO project_task (task_id, project_id) VALUES (6, 6);
INSERT INTO project_task (task_id, project_id) VALUES (7, 11);
INSERT INTO project_task (task_id, project_id) VALUES (8, 6);
INSERT INTO project_task (task_id, project_id) VALUES (19, 14);
INSERT INTO project_task (task_id, project_id) VALUES (14, 15);
INSERT INTO project_task (task_id, project_id) VALUES (20, 13);
INSERT INTO project_task (task_id, project_id) VALUES (2, 16);
INSERT INTO project_task (task_id, project_id) VALUES (10, 2);
INSERT INTO project_task (task_id, project_id) VALUES (13, 11);
INSERT INTO project_task (task_id, project_id) VALUES (12, 13);
INSERT INTO project_task (task_id, project_id) VALUES (3, 20);
-- Inserting data into the 'project_tag' table
INSERT INTO project_tag (tag_id, project_id) VALUES (1, 1);
INSERT INTO project_tag (tag_id, project_id) VALUES (2, 12);
INSERT INTO project_tag (tag_id, project_id) VALUES (19, 18);
INSERT INTO project_tag (tag_id, project_id) VALUES (16, 16);
INSERT INTO project_tag (tag_id, project_id) VALUES (8, 11);
INSERT INTO project_tag (tag_id, project_id) VALUES (17, 19);
INSERT INTO project_tag (tag_id, project_id) VALUES (3, 6);
INSERT INTO project_tag (tag_id, project_id) VALUES (11, 2);
INSERT INTO project_tag (tag_id, project_id) VALUES (9, 3);
INSERT INTO project_tag (tag_id, project_id) VALUES (6, 7);
INSERT INTO project_tag (tag_id, project_id) VALUES (5, 7);
INSERT INTO project_tag (tag_id, project_id) VALUES (13, 7);
INSERT INTO project_tag (tag_id, project_id) VALUES (10, 14);
INSERT INTO project_tag (tag_id, project_id) VALUES (20, 8);
INSERT INTO project_tag (tag_id, project_id) VALUES (18, 19);
-- Inserting data into the 'tag_task' table
INSERT INTO tag_task (tag_id, task_id) VALUES (1, 1);
INSERT INTO task_user (user_id, task_id) VALUES (1, 1);

