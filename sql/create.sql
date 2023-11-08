-- SCHEMA OPERATIONS
SET search_path TO lbaw2353;

-- DROP TABLES
DROP TABLE IF EXISTS lbaw2353.users CASCADE;
DROP TABLE IF EXISTS lbaw2353.administrator CASCADE; 
DROP TABLE IF EXISTS lbaw2353.project CASCADE;
DROP TABLE IF EXISTS lbaw2353.tag CASCADE;
DROP TABLE IF EXISTS lbaw2353.task CASCADE;
DROP TABLE IF EXISTS lbaw2353.post CASCADE;
DROP TABLE IF EXISTS lbaw2353.assigned CASCADE;
DROP TABLE IF EXISTS lbaw2353.comment CASCADE;
DROP TABLE IF EXISTS lbaw2353.file CASCADE;
DROP TABLE IF EXISTS lbaw2353.invite CASCADE;
DROP TABLE IF EXISTS lbaw2353.invite_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.forum_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.task_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.comment_notification CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_participation CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_task CASCADE;
DROP TABLE IF EXISTS lbaw2353.project_tag CASCADE;
DROP TABLE IF EXISTS lbaw2353.task_tag CASCADE;

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
    is_blocked BOOLEAN NOT NULL DEFAULT FALSE
);
-- 1
CREATE TABLE lbaw2353.administrator(
    id SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
--0 CHECK IMAGE
CREATE TABLE lbaw2353.project (
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    description TEXT,
    is_archived BOOLEAN DEFAULT FALSE,
    creation TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    deadline TIMESTAMP WITH TIME ZONE NOT NULL CHECK (creation < deadline),
    coordinator INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);
--1 
CREATE TABLE lbaw2353.tag(
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL
);
-- 0 starttime default?
CREATE TABLE lbaw2353.task (
    id SERIAL PRIMARY KEY,
    title VARCHAR(20) NOT NULL,
    description VARCHAR(100),
    status lbaw2353.task_status NOT NULL,
    starttime TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    endtime TIMESTAMP WITH TIME ZONE ,
    deadline TIMESTAMP WITH TIME ZONE NOT NULL CHECK (starttime < deadline),
    opened_user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL,
    closed_user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL
);
--1 (default not in schema)
CREATE TABLE lbaw2353.post(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    submit_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    last_edited TIMESTAMP WITH TIME ZONE DEFAULT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);
--1 
CREATE TABLE lbaw2353.assigned(
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE, 
    task_id INTEGER REFERENCES lbaw2353.task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (user_id,task_id)
);
--1 (DEFAULTS TO SEE)
CREATE TABLE lbaw2353.comment(
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    submit_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    last_edited TIMESTAMP WITH TIME ZONE DEFAULT NULL,
    task_id INTEGER REFERENCES lbaw2353.task(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE SET DEFAULT NULL
);
--1
CREATE TABLE lbaw2353.file(
    id SERIAL PRIMARY KEY,
    name VARCHAR(1000) NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    UNIQUE(name,project_id)
);

CREATE TABLE lbaw2353.invite (
    id SERIAL PRIMARY KEY,
    email VARCHAR(1000) NOT NULL,
    invite_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    accepted BOOLEAN NOT NULL DEFAULT FALSE,
    UNIQUE (email, project_id)
);

CREATE TABLE lbaw2353.invite_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    invite_id INTEGER REFERENCES lbaw2353.invite(id) ON UPDATE CASCADE NOT NULL UNIQUE, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.forum_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL ,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    post_id INTEGER REFERENCES lbaw2353.post(id) ON UPDATE CASCADE NOT NULL,
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.project_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.task_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    task_id INTEGER REFERENCES lbaw2353.task(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.comment_notification (
    id SERIAL PRIMARY KEY,
    description VARCHAR(1000) NOT NULL,
    notification_date TIMESTAMP WITH TIME ZONE DEFAULT NOW() NOT NULL,
    comment_id INTEGER REFERENCES lbaw2353.comment(id) ON UPDATE CASCADE NOT NULL, 
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL, 
    seen BOOLEAN DEFAULT FALSE NOT NULL
);
CREATE TABLE lbaw2353.project_participation (
    user_id INTEGER REFERENCES lbaw2353.users(id) ON UPDATE CASCADE ON DELETE CASCADE, 
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (user_id, project_id)
);
CREATE TABLE lbaw2353.project_task(
    task_id INTEGER REFERENCES lbaw2353.task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    PRIMARY KEY(task_id)
);
--1
CREATE TABLE lbaw2353.project_tag(
    tag_id INTEGER REFERENCES lbaw2353.tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
    project_id INTEGER REFERENCES lbaw2353.project(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    PRIMARY KEY(tag_id)
);
--1
CREATE TABLE lbaw2353.task_tag(
    tag_id INTEGER REFERENCES lbaw2353.tag(id) ON UPDATE CASCADE ON DELETE CASCADE,
    task_id INTEGER REFERENCES lbaw2353.task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (tag_id,task_id)
);

--------------------------------------------------------
-- Performance Indexes 
--------------------------------------------------------

CREATE INDEX comment_taks ON lbaw2353.comment USING hash (task_id);

CREATE INDEX tasks_in_project ON lbaw2353.project_task USING hash (project_id);

CREATE INDEX task_deadline ON lbaw2353.task USING btree (deadline);

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

ALTER TABLE lbaw2353.file
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
BEFORE INSERT OR UPDATE ON file
FOR EACH ROW
EXECUTE PROCEDURE file_search_update();

CREATE INDEX search_file ON file USING GIN (tsvectors);

ALTER TABLE lbaw2353.project
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
BEFORE INSERT OR UPDATE ON lbaw2353.project
FOR EACH ROW
EXECUTE PROCEDURE project_search_update();

CREATE INDEX search_project ON lbaw2353.project USING GIN (tsvectors);

ALTER TABLE lbaw2353.tag
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
BEFORE INSERT OR UPDATE ON tag
FOR EACH ROW
EXECUTE PROCEDURE tag_search_update();

CREATE INDEX search_user_tag ON tag USING GIN (tsvectors);

--------------------------------------------------------
-- Triggers
--------------------------------------------------------


/*-When sending an invitation from a project to a user if an invitation from the same project to the same email already exist then,
the value of the invite_date should be changed to current date and the row should not be inserted
*/
/*The project coordinator can only send an invitation to the same user each 10 minutes*/

CREATE OR REPLACE FUNCTION update_invitation_date() RETURNS TRIGGER AS 
$BODY$
DECLARE
    past_time TIMESTAMP;
    time_difference DOUBLE PRECISION; -- Define time_difference variable
BEGIN
    IF EXISTS (SELECT 1 FROM lbaw2353.invite WHERE email = NEW.email AND project_id = NEW.project_id) THEN
		past_time :=	(SELECT invite_date 
		FROM invite
		WHERE email = NEW.email AND project_id = NEW.project_id);
		
    	time_difference := EXTRACT(EPOCH FROM NOW()) - EXTRACT(EPOCH FROM past_time);
	
    	IF time_difference < 600.0 THEN
     	   RAISE EXCEPTION 'You have already sent an invite in the past 10 minutes';
    	ELSE
			DELETE FROM lbaw2353.invite WHERE email = NEW.email;
    		RETURN NEW;
    	END IF;
	ELSE
      RETURN NEW;
    END IF;
END 
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER send_invitation
BEFORE INSERT ON lbaw2353.invite
FOR EACH ROW
EXECUTE FUNCTION update_invitation_date();


/* -When a comment is send, a notification should be created for all the users assigned to the task*/

CREATE OR REPLACE FUNCTION send_comment_notification()
RETURNS TRIGGER AS $$
DECLARE
    task_id_ INTEGER;
BEGIN
     task_id_:=(SELECT id FROM lbaw2353.task WHERE id in (SELECT task_id FROM lbaw2353.comment WHERE id = NEW."id"));
     

    
    INSERT INTO lbaw2353.comment_notification (description, notification_date, comment_id, user_id)
    SELECT
        'New comment on task ' || NEW.content,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.assigned
    WHERE task_id = task_id_;    

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER send_comment_notification_trigger
AFTER INSERT ON lbaw2353.comment
FOR EACH ROW
EXECUTE FUNCTION send_comment_notification();





/*-When a post is send , a notification should be created for all the users that participate in the project*/

CREATE OR REPLACE FUNCTION send_forum_notification()
RETURNS TRIGGER AS $$
DECLARE
    proj_id INTEGER;
BEGIN

    proj_id:=(SELECT id FROM lbaw2353.project WHERE id in (SELECT project_id FROM lbaw2353.post WHERE id = NEW."id"));

    INSERT INTO lbaw2353.forum_notification (description, notification_date, post_id, user_id)
    SELECT
        'New post in project ' || NEW."content",
        NOW(),
        NEW."id",
        user_id
    FROM lbaw2353.project_participation
    WHERE project_id = proj_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER send_forum_notification_trigger
AFTER INSERT ON lbaw2353.post
FOR EACH ROW
EXECUTE FUNCTION send_forum_notification();



/*-When the status of a task is changed a notification should be created for all the users assigned to a task*/
CREATE OR REPLACE FUNCTION send_task_state_notification()
RETURNS TRIGGER AS $$
BEGIN
 
    INSERT INTO lbaw2353.task_notification (description, notification_date, task_id, user_id)
    SELECT
        'Task state changed to ' || NEW.status,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.assigned
    WHERE task_id = NEW.task_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER task_state_notification_trigger
AFTER UPDATE ON lbaw2353.task
FOR EACH ROW
WHEN (NEW.status <> OLD.status)
EXECUTE FUNCTION send_task_state_notification();











/*-When the project state is changed a notification should be created for all the users in the project*/

CREATE OR REPLACE FUNCTION send_project_state_notification()
RETURNS TRIGGER AS $$
BEGIN
  
    INSERT INTO lbaw2353.project_notification (description, notification_date, project_id, user_id)
    SELECT
        'Project state changed to ' || NEW.is_archived,
        NOW(),
        NEW.id,
        user_id
    FROM lbaw2353.project_participation
    WHERE project_id = NEW.id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER project_state_notification_trigger
AFTER UPDATE ON lbaw2353.project
FOR EACH ROW
WHEN (NEW.is_archived <> OLD.is_archived)
EXECUTE FUNCTION send_project_state_notification();




/*-When a post is edited it's lastedited attribute should be updated to the current date*/
CREATE OR REPLACE FUNCTION update_last_edit_post_date()
RETURNS TRIGGER AS $$
BEGIN
 
    NEW.last_edited := NOW();

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER edit_post_trigger
AFTER UPDATE ON lbaw2353.post
FOR EACH ROW
WHEN (NEW.content <> OLD.content)
EXECUTE FUNCTION update_last_edit_post_date();







/*-When a comment is edited it's lastedited attribute should be updated to the current date*/
CREATE OR REPLACE FUNCTION update_last_edit_comment_date()
RETURNS TRIGGER AS $$
BEGIN

    NEW.last_edited := NOW();

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER edit_comment_trigger
AFTER UPDATE ON lbaw2353.comment
FOR EACH ROW
WHEN (NEW.content <> OLD.content)
EXECUTE FUNCTION update_last_edit_comment_date();



/*-When the state of a task is changed to closed then the end attribute should change to the current date*/
CREATE OR REPLACE FUNCTION update_task_end_date()
RETURNS TRIGGER AS $$
BEGIN

    NEW.endtime := NOW();

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER finalize_task_trigger
AFTER UPDATE ON lbaw2353.task
FOR EACH ROW
WHEN (NEW.status <> OLD.status AND NEW.status = 'closed')
EXECUTE FUNCTION update_task_end_date();

/*Only a user who is part of the project's team can be assigned as the project coordinator for that project*/

CREATE OR REPLACE FUNCTION check_for_coordinator_in_project()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.coordinator NOT IN (SELECT user_id FROM lbaw2353.projectParticipation WHERE project_id = NEW.id) THEN
        RAISE EXCEPTION 'Only a user who is part of the project''s team can be assigned as the project coordinator.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER coordinator_assignment_trigger
BEFORE UPDATE ON lbaw2353.project
FOR EACH ROW
WHEN (NEW.coordinator <> OLD.coordinator) 
EXECUTE FUNCTION check_for_coordinator_in_project();

/*Only project coordinators can invite users to join their project*/

CREATE OR REPLACE FUNCTION check_if_coordinator_send_invitation()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id NOT IN (SELECT coordinator FROM lbaw2353.project WHERE id = NEW.project_id) THEN
        RAISE EXCEPTION 'Only project coordinators can invite users to join their project.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER coordinator_send_invitation_trigger
BEFORE INSERT ON lbaw2353.invite
FOR EACH ROW
EXECUTE FUNCTION check_if_coordinator_send_invitation();


/*Each task can only be marked as completed by users that are assigned to the task or the project coordinator*/

CREATE OR REPLACE FUNCTION check_who_closed_task()
RETURNS TRIGGER AS $$
BEGIN
    IF  NEW.closed_user_id NOT IN (SELECT user_id FROM lbaw2353.assigned WHERE task_id = NEW.id) AND
        NEW.closed_user_id <> (SELECT coordinator FROM lbaw2353.project WHERE id = (SELECT project_id FROM lbaw2353.projectTask WHERE task_id = NEW.id)) THEN
        RAISE EXCEPTION 'Each task can only be marked as completed by users that are assigned to the task or the project coordinator.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER task_closed_trigger
BEFORE UPDATE ON lbaw2353.task
FOR EACH ROW
WHEN (NEW.status <> OLD.status AND NEW.status = 'closed') 
EXECUTE FUNCTION check_who_closed_task();
