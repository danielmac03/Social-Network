CREATE TABLE users(
    id int (255) auto_increment not null,
    user varchar (100) not null UNIQUE,
    email varchar (255) not null UNIQUE,
    password varchar (255) not null,
    steam varchar (255) null,
    twitter varchar (255) null,
    youtube varchar (255) null,
    profile_picture varchar (255) DEFAULT 'default.png' null,
    create_datetime datetime not null,
    last_connection_datetime datetime null,
    private_account bit DEFAULT 0 not null,
    staff bit DEFAULT 0 not null,
    verificate bit DEFAULT 0 not null,
    CONSTRAINT pk_users PRIMARY KEY (id)
);

CREATE TABLE votes(
    id int (255) auto_increment not null,
    clips int (255) not null,
    user int (255) not null,
    create_datetime datetime not null,
    CONSTRAINT pk_votes PRIMARY KEY (id),
    CONSTRAINT fk_users_votes FOREIGN KEY (user) REFERENCES users(id)
);

CREATE TABLE events(
    id int (255) auto_increment not null,
    user_host int(255) not null,
    description varchar(255) not null,
    voice_channel varchar(255) not null,
    max_users int(100) not null,
    users varchar(255) null,
    create_datetime datetime not null,
    edit_datetime datetime null,
    reports int(255) not null,
    hide bit DEFAULT 0 not null,
    CONSTRAINT pk_events PRIMARY KEY (id),
    CONSTRAINT fk_user_host_events FOREIGN KEY (user_host) REFERENCES users(id)
);

CREATE TABLE friends(
    id int(255) auto_increment not null,
    user_send int(255) not null,
    user_receive int(255) not null,
    accept int(255) not null,
    notify int(255) not null,
    create_datetime datetime not null,
    CONSTRAINT pk_friends PRIMARY KEY (id),
    CONSTRAINT fk_user_send_friends FOREIGN KEY (user_send) REFERENCES users(id),
    CONSTRAINT fk_user_receive_friends FOREIGN KEY (user_receive) REFERENCES users(id)
);

CREATE TABLE entries(
    id int (255) auto_increment not null,
    user_id int(255) not null,
    entry varchar(200) null,
    file_entry varchar (255) null,
    likes int(255) not null DEFAULT 0,
    only_followers bit not null,
    create_datetime datetime not null,
    edit_datetime datetime null,
    reports int(255) not null,
    hide bit DEFAULT 0 not null,
    CONSTRAINT pk_entries PRIMARY KEY (id),
    CONSTRAINT fk_users_entries FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments(
    id int (255) auto_increment not null,
    user_id int(255) not null,
    entry_id int(255) not null,
    comment varchar (255) not null,
    create_datetime datetime not null,
    edit_datetime datetime null,
    reports int(255) not null,
    hide bit DEFAULT 0 not null,
    CONSTRAINT pk_comments PRIMARY KEY (id),
    CONSTRAINT fk_users_comments FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_entries_comments FOREIGN KEY (entry_id) REFERENCES entries(id)
);

CREATE TABLE reports(
    id int (255) auto_increment not null,
    report int (255) not null,
    user int (255) not null,
    type_report varchar (255) not null,
    create_datetime datetime not null,
    CONSTRAINT pk_reports PRIMARY KEY (id),
    CONSTRAINT fk_users_reports FOREIGN KEY (user) REFERENCES users(id)
);

CREATE TABLE hide(
    id int (255) auto_increment not null,
    user int (255) not null,
    type varchar(255) not null,
    create_datetime datetime not null,
    CONSTRAINT pk_hide PRIMARY KEY (id),
    CONSTRAINT fk_users_hide FOREIGN KEY (user) REFERENCES users(id)
);

CREATE TABLE tokens(
    id int(255) auto_increment not null,
    user int(255) not null,
    token varchar(255) not null,
    create_datetime datetime not null,
    CONSTRAINT pk_token PRIMARY KEY (id),
    CONSTRAINT fk_users_token FOREIGN KEY (user) REFERENCES users(id)
);