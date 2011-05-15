drop view if exists asterisk_sip;
drop table if exists asterisk_sip;
CREATE VIEW asterisk_sip AS 
    SELECT
        p.id, 
        p.name,
        p.type,
        p.callerid,   
        p.defaultuser,
        (SELECT 
                (case
                        when (Select a.password from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select SUBSTR(a.password,0,8) from residents a, rooms b
                                where a.room = b.id and b.phone = p.id 
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))
                        else 'hekphone'
                end)
        ) AS secret,
        p.host,
        p.defaultip,
        p.mac,
        p.language,
        p.mailbox,
        p.regserver,
        p.regseconds,
        p.ipaddr,
        p.port,
        p.fullcontact,
        p.useragent,
        p.lastms,
        '00497218695' || p.name AS cid_number,
        (SELECT 
                (case
                        when (Select a.unlocked from residents a, rooms b 
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select a.unlocked from residents a, rooms b 
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))::context
                        else 'locked'::context
                end)
        ) AS context
        from phones p 
        where technology = 'SIP';

CREATE RULE asterisk_sip_update AS
    ON UPDATE TO asterisk_sip
    DO INSTEAD
        UPDATE phones SET
            id = NEW.id, 
            name = NEW.name,
            type = NEW.type,
            callerid = NEW.callerid,   
            defaultuser = OLD.defaultuser, -- prevent asterisk from overwriting the value, the phone would not be able to register otherwise
            secret = NEW.secret,
            host = NEW.host,
            defaultip = NEW.defaultip,
            mac = NEW.mac,
            language = NEW.language,
            mailbox = NEW.mailbox,
            regserver = NEW.regserver,
            regseconds = NEW.regseconds,
            ipaddr = NEW.ipaddr,
            port = NEW.port,
            fullcontact = NEW.fullcontact,
            useragent = NEW.useragent,
            lastms = NEW.lastms
        WHERE id = NEW.id;

GRANT ALL ON asterisk_sip to asterisk;
