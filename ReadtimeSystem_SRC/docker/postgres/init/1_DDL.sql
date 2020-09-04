--
-- Name: account_id; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.account_id (
    account integer,
    coid character varying(15)
);


ALTER TABLE public.account_id OWNER TO postgres;

--
-- Name: account_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.account_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.account_id_seq OWNER TO postgres;

--
-- Name: address; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.address (
    addrcd integer,
    jiscode character varying(8),
    zipcode character varying(8),
    pref character varying(2),
    siku character varying(40),
    tyou character varying(100),
    depocd integer,
    depocd_sp integer,
    depocd_tlk integer,
    depocd_wan integer,
    depocd_lc integer,
    depocd_medal integer,
    depocd_hana integer,
    depocd_arrange integer,
    depocd_art integer,
    depocd_jfn integer,
    depocd_vip integer,
    depocd_type12 integer,
    depocd_type13 integer,
    depocd_type14 integer,
    depocd_type15 integer,
    depocd_type16 integer,
    depocd_type17 integer,
    depocd_type18 integer,
    depocd_type19 integer,
    depocd_type20 integer,
    depocd_type21 integer,
    depocd_type22 integer,
    depocd_type23 integer,
    depocd_type24 integer,
    depocd_type25 integer,
    depocd_type26 integer,
    depocd_type27 integer,
    depocd_type28 integer,
    depocd_type29 integer,
    depocd_type30 integer,
    depocd_type31 integer,
    depocd_type32 integer,
    depocd_type33 integer,
    depocd_type34 integer,
    depocd_type35 integer,
    depocd_type36 integer
);


ALTER TABLE public.address OWNER TO postgres;

--
-- Name: address_book; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.address_book (
    address_book_id integer DEFAULT nextval(('address_book_id_seq'::text)::regclass) NOT NULL,
    usercd integer NOT NULL,
    title character varying(36),
    a_post character(7) NOT NULL,
    a_pref character varying(2) NOT NULL,
    a_siku character varying(20) NOT NULL,
    a_tyou character varying(200) NOT NULL,
    a_addr character varying(100),
    a_build character varying(100),
    a_cerehall character varying(100),
    a_tel character varying(15),
    a_name1 character varying(60),
    a_keisho1 character varying(60),
    a_name2 character varying(60),
    a_keisho2 character varying(60),
    remark text,
    permit boolean DEFAULT true NOT NULL,
    insert_at timestamp without time zone DEFAULT now() NOT NULL,
    update_at timestamp without time zone,
    last_used timestamp without time zone
);


ALTER TABLE public.address_book OWNER TO postgres;

--
-- Name: address_book_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.address_book_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.address_book_id_seq OWNER TO postgres;

--
-- Name: adm_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.adm_log_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.adm_log_seq OWNER TO postgres;

--
-- Name: agent; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent (
    ag_id character varying(13) NOT NULL,
    d_seikyuu character varying(2) DEFAULT '3'::character varying,
    k_seikyuu character varying(2) DEFAULT '1'::character varying
);


ALTER TABLE public.agent OWNER TO postgres;

--
-- Name: agent_summary_id_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.agent_summary_id_tb (
    coid character varying(12) NOT NULL,
    agent_name character varying(60),
    list_id text,
    to_email character varying(50),
    cc_email character varying(50),
    obj_seikyuu character varying(2),
    bikou character varying(60),
    flg character varying(1),
    del_flg character varying(1),
    e_code character varying(10),
    reg_date timestamp without time zone
);


ALTER TABLE public.agent_summary_id_tb OWNER TO postgres;

--
-- Name: aji_ordercd; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.aji_ordercd (
    ordercd integer NOT NULL,
    ordernum smallint NOT NULL,
    s_date date
);


ALTER TABLE public.aji_ordercd OWNER TO postgres;

--
-- Name: alert_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.alert_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alert_id_seq OWNER TO postgres;

--
-- Name: all_section_quest; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.all_section_quest (
    q_cd integer NOT NULL,
    q_date timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL,
    q_cname character varying(60),
    q_category_cd character varying(2),
    q_name character varying(60),
    q_mail character varying(50),
    q_tel character varying(15),
    q_naiyou text,
    r_tantou character varying(20),
    r_date timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL,
    r_naiyou text,
    permit_flg character varying(2)
);


ALTER TABLE public.all_section_quest OWNER TO postgres;

--
-- Name: ast_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ast_log (
    ast_log_seq integer DEFAULT nextval(('ast_log_seq'::text)::regclass) NOT NULL,
    parm1 character varying(20),
    parm2 character varying(120),
    parm3 character varying(300),
    parm4 character varying(20),
    parm5 character varying(20),
    gr_cd character varying(20),
    syo_cd character varying(20),
    yos_cd character varying(20),
    login_type character varying(2),
    usercd integer,
    row_cnt integer,
    sso_time timestamp with time zone
);


ALTER TABLE public.ast_log OWNER TO postgres;

--
-- Name: ast_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ast_log_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.ast_log_seq OWNER TO postgres;

--
-- Name: ast_s; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ast_s (
    gr_cd character varying(4),
    syo_cd character varying(12),
    syo_name character varying(258),
    yos_cd character varying(10)
);


ALTER TABLE public.ast_s OWNER TO postgres;

--
-- Name: ast_y; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ast_y (
    yos_cd character varying(10),
    yos_name character varying(64)
);


ALTER TABLE public.ast_y OWNER TO postgres;

--
-- Name: b_order_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.b_order_item (
    b_ordercd integer NOT NULL,
    b_ordernum smallint NOT NULL,
    item_type character varying(2),
    b_money1 integer,
    b_margin integer,
    item_cd character varying(10),
    attr_1 character varying(60),
    attr_2 character varying(60),
    attr_3 character varying(60),
    attr_4 character varying(60),
    attr_5 character varying(60),
    attr_6 character varying(60),
    attr_7 character varying(60),
    attr_8 character varying(60),
    attr_9 character varying(60),
    attr_10 character varying(60),
    attr_11 character varying(60),
    attr_12 character varying(60),
    attr_13 character varying(60),
    attr_14 character varying(60),
    attr_15 character varying(60),
    attr_16 character varying(60),
    attr_17 character varying(60),
    attr_18 character varying(60),
    attr_19 character varying(60),
    attr_20 character varying(60),
    attr_21 character varying(60),
    attr_22 character varying(60)
);


ALTER TABLE public.b_order_item OWNER TO postgres;

--
-- Name: b_order_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.b_order_master (
    b_ordercd integer NOT NULL,
    benri_id integer NOT NULL,
    a_post character varying(8),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    m_coname character varying(60),
    m_branch character varying(60),
    m_section character varying(60),
    m_yaku character varying(60),
    m_name character varying(60),
    m_post character varying(8),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_tel character varying(15),
    m_fax character varying(15),
    m_mail character varying(50),
    bikou character varying(60),
    b_date timestamp with time zone DEFAULT now(),
    a_date date NOT NULL,
    c_date date NOT NULL,
    c_time character varying(6),
    l_date timestamp with time zone NOT NULL,
    check_1 boolean DEFAULT false,
    check_2 boolean DEFAULT false,
    check_3 boolean DEFAULT false,
    r_ordercd integer DEFAULT 0,
    nouhin character varying(1) DEFAULT '0'::character varying
);


ALTER TABLE public.b_order_master OWNER TO postgres;

--
-- Name: b_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.b_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.b_ordercd_seq OWNER TO postgres;

--
-- Name: b_syukka; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.b_syukka (
    r_num smallint NOT NULL,
    s_date1 date NOT NULL,
    s_num integer NOT NULL,
    m_num smallint NOT NULL,
    b_ordercd integer NOT NULL,
    t_date timestamp with time zone DEFAULT now(),
    s_check boolean DEFAULT false
);


ALTER TABLE public.b_syukka OWNER TO postgres;

--
-- Name: bank_account; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bank_account (
    bank_account_id integer NOT NULL,
    bank_name character varying(60),
    bank_branch character varying(60),
    account_num_system smallint,
    account_type smallint,
    account_num character varying(12),
    kigou character varying(10),
    bangou character varying(10),
    meigi character varying(60),
    disp_turn integer,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bank_account OWNER TO postgres;

--
-- Name: bank_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bank_master (
    bank_cd character(4) NOT NULL,
    bank_nm character varying(90) NOT NULL,
    bank_kana character varying(90) NOT NULL,
    branch_cd character(3) NOT NULL,
    branch_nm character varying(90) NOT NULL,
    branch_kana character varying(90) NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bank_master OWNER TO postgres;

--
-- Name: benri_nouhin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.benri_nouhin (
    n_cd integer DEFAULT nextval(('"benri_nouhin_n_cd_seq"'::text)::regclass) NOT NULL,
    n_date date,
    ordercd integer DEFAULT 0,
    pre_ocd integer DEFAULT 0,
    benri_num1 integer,
    benri_num2 smallint,
    attr_1 character varying(1),
    attr_2 boolean DEFAULT false,
    attr_3 character varying(1),
    n_date2 date
);


ALTER TABLE public.benri_nouhin OWNER TO postgres;

--
-- Name: benri_nouhin_n_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.benri_nouhin_n_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.benri_nouhin_n_cd_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: bikou_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bikou_tb (
    coid character varying(12) NOT NULL,
    ag1 character varying(12),
    ag2 character varying(12),
    ag3 character varying(12),
    coname_str character varying(60),
    pattern_type character(1),
    p1_text character varying(60),
    check_list0 text,
    check_list1 text,
    check_list2 text,
    check_list3 text,
    set_message text,
    alt_bikou character varying(60),
    alt_note text,
    note character varying(60),
    e_code character varying(10),
    flg character varying(1),
    reg_date timestamp without time zone
);


ALTER TABLE public.bikou_tb OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: bill_category_plan_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_category_plan_master (
    bill_category_plan_master_id integer DEFAULT nextval(('bill_category_plan_master_id_seq'::text)::regclass) NOT NULL,
    coid character varying(13),
    remark text,
    default_flg boolean DEFAULT false NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bill_category_plan_master OWNER TO postgres;

--
-- Name: bill_category_plan_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bill_category_plan_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.bill_category_plan_master_id_seq OWNER TO postgres;

--
-- Name: bill_category_plan_relation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_category_plan_relation (
    bill_category_plan_master_id integer NOT NULL,
    bill_mcat_id integer NOT NULL,
    bill_lcat_id integer NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bill_category_plan_relation OWNER TO postgres;

--
-- Name: bill_item_mcat_relation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_item_mcat_relation (
    mcat_cd integer NOT NULL,
    bill_mcat_id integer NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bill_item_mcat_relation OWNER TO postgres;

--
-- Name: bill_lcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_lcat (
    bill_lcat_id integer NOT NULL,
    bill_lcat_nm character varying(30) NOT NULL,
    dsp_turn smallint,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bill_lcat OWNER TO postgres;

--
-- Name: bill_lcat_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_lcat_data (
    s_cd integer NOT NULL,
    bill_lcat_id integer NOT NULL,
    branch_number integer,
    check_date timestamp with time zone,
    keiri_bikou character varying(60),
    total1 integer,
    total2 integer
);


ALTER TABLE public.bill_lcat_data OWNER TO postgres;

--
-- Name: bill_mcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_mcat (
    bill_mcat_id integer NOT NULL,
    bill_mcat_nm character varying(30) NOT NULL,
    dsp_turn smallint,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.bill_mcat OWNER TO postgres;

--
-- Name: bill_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_opt (
    s_cd integer NOT NULL,
    pay_type smallint NOT NULL,
    pay_day character varying(2) NOT NULL,
    account_num integer
);


ALTER TABLE public.bill_opt OWNER TO postgres;

--
-- Name: bill_opt_general_account; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bill_opt_general_account (
    s_cd integer NOT NULL,
    bank_account_id integer NOT NULL
);


ALTER TABLE public.bill_opt_general_account OWNER TO postgres;

--
-- Name: bk_name; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bk_name (
    bkcd integer NOT NULL,
    coid character varying(13) NOT NULL,
    b_type character varying(2),
    bkname character varying(60),
    bkbranch character varying(60),
    bktype character varying(2),
    bknum character varying(12),
    kigou character varying(10),
    bangou character varying(10),
    meigi character varying(60)
);


ALTER TABLE public.bk_name OWNER TO postgres;

--
-- Name: btov_if; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.btov_if (
    benri_id integer DEFAULT nextval(('btov_if_benri_id_seq'::text)::regclass) NOT NULL,
    login_id character varying(12),
    user_number character varying(16),
    front_id character varying(8),
    return_url character varying(300),
    select_itemmax smallint,
    reserve_1 character varying(200),
    reserve_2 character varying(200),
    reserve_3 character varying(200),
    acs_date timestamp with time zone DEFAULT now()
);


ALTER TABLE public.btov_if OWNER TO postgres;

--
-- Name: btov_if_benri_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.btov_if_benri_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.btov_if_benri_id_seq OWNER TO postgres;

--
-- Name: bunrei; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bunrei (
    buncd character varying(8),
    cate_cd character varying(4),
    cate_name character varying(40),
    text1 character varying(64),
    text2 character varying(64),
    text3 character varying(64),
    text4 character varying(64),
    text5 character varying(64),
    text6 character varying(64),
    text7 character varying(64),
    text8 character varying(64),
    text9 character varying(64),
    text10 character varying(64),
    k_cate_sort_num integer,
    k_bun_sort_num integer,
    v_cate_sort_num integer,
    v_bun_sort_num integer,
    b_flg integer,
    message_candidate character varying(4)
);


ALTER TABLE public.bunrei OWNER TO postgres;

--
-- Name: c_biz; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.c_biz (
    biz_id character varying(12) NOT NULL,
    biz_nm character varying(60) NOT NULL,
    item_dsp_turn integer,
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.c_biz OWNER TO postgres;

--
-- Name: contact_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.contact_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.contact_id_seq OWNER TO postgres;

--
-- Name: c_contact; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.c_contact (
    contact_id integer DEFAULT nextval('public.contact_id_seq'::regclass) NOT NULL,
    contact_nm character varying(60) NOT NULL,
    item_dsp_turn integer,
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.c_contact OWNER TO postgres;

--
-- Name: c_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.c_master (
    coid character varying(12),
    c_name character varying(60),
    c_branch character varying(60),
    c_section character varying(60),
    c_post character varying(8),
    c_pref character varying(2),
    c_addr character varying(100),
    c_build character varying(100),
    tantou character varying(40),
    c_class character varying(2),
    ag_1 character varying(12),
    ag_2 character varying(12),
    ag_3 character varying(12),
    card_m smallint,
    gift_m smallint,
    flower_m smallint,
    eigyou character varying(40),
    seikyuufee character varying(2),
    seikyuu character varying(2),
    e_date timestamp with time zone,
    c_bikou character varying(40),
    attr_1 character varying(20),
    attr_2 character varying(20),
    attr_3 character varying(20),
    attr_4 character varying(20),
    attr_5 character varying(20),
    s_flg character(1) DEFAULT '0'::bpchar NOT NULL,
    s_date_applied date DEFAULT to_date(to_char((now() + '1 mon'::interval), 'YYYY-MM-01'::text), 'YYYY-MM-DD'::text),
    c_mail_magazine character(1) DEFAULT '0'::bpchar NOT NULL,
    c_biz character varying(12),
    c_scale integer,
    c_contact integer
);


ALTER TABLE public.c_master OWNER TO postgres;

--
-- Name: c_scale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.c_scale (
    scale_id integer NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.c_scale OWNER TO postgres;

--
-- Name: c_user_temporary; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.c_user_temporary (
    temporary_id character varying(32) NOT NULL,
    c_name character varying(60),
    c_branch character varying(60),
    c_section character varying(60),
    c_post character varying(8),
    c_pref character varying(2),
    c_addr character varying(100),
    c_build character varying(100),
    tantou character varying(40),
    c_class character varying(2),
    ag_1 character varying(12),
    ag_2 character varying(12),
    ag_3 character varying(12),
    card_m smallint,
    gift_m smallint,
    flower_m smallint,
    eigyou character varying(40),
    seikyuufee character varying(2),
    seikyuu character varying(2),
    e_date timestamp without time zone DEFAULT now() NOT NULL,
    c_bikou character varying(40),
    s_flg character(1) DEFAULT '0'::bpchar,
    c_mail_magazine character(1) DEFAULT '0'::bpchar NOT NULL,
    c_biz character varying(12),
    c_scale integer,
    c_contact integer,
    c_hikiotoshi boolean,
    coid character varying(12),
    pass character varying(20),
    u_name character varying(60),
    u_tel character varying(15),
    u_fax character varying(15),
    u_mail character varying(50),
    u_branch character varying(60),
    u_section character varying(60),
    u_yaku character varying(60),
    admin boolean,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.c_user_temporary OWNER TO postgres;

--
-- Name: cam_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cam_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 10889999
    CACHE 1
    CYCLE;


ALTER TABLE public.cam_cd_seq OWNER TO postgres;

--
-- Name: cam_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cam_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.cam_num_seq OWNER TO postgres;

--
-- Name: campaign; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.campaign (
    cam_cd character varying(8) NOT NULL,
    ordercd integer NOT NULL,
    enable boolean DEFAULT true NOT NULL,
    cam_date date NOT NULL,
    cam_num integer
);


ALTER TABLE public.campaign OWNER TO postgres;

--
-- Name: campaign_list; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.campaign_list (
    cam_num integer NOT NULL,
    name1 character varying(60) NOT NULL,
    name2 character varying(60),
    age character varying(3),
    gender character(1),
    post character varying(7),
    pref character varying(2),
    addr character varying(100),
    tel character varying(15),
    mail character varying(50),
    mail_flg boolean DEFAULT true,
    e_date timestamp with time zone,
    cam_flg boolean DEFAULT false NOT NULL,
    cam_cd character varying(8),
    cam_item_id integer,
    ip_addr cidr,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.campaign_list OWNER TO postgres;

--
-- Name: item_group_choice; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_group_choice (
    item_group_choice_id integer DEFAULT nextval(('item_group_choice_id_seq'::text)::regclass) NOT NULL,
    item_group_key character varying(255) NOT NULL,
    value character varying(255) NOT NULL,
    name character varying(255),
    dsp_turn integer NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_group_choice OWNER TO postgres;

--
-- Name: item_group_choice_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_group_choice_link (
    item_group_choice_link_id integer DEFAULT nextval(('item_group_choice_link_id_seq'::text)::regclass) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_group_choice_id integer NOT NULL,
    dsp_turn integer NOT NULL
);


ALTER TABLE public.item_group_choice_link OWNER TO postgres;

--
-- Name: item_sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_sale (
    item_id integer DEFAULT nextval(('item_id_seq'::text)::regclass) NOT NULL,
    lcat_cd smallint NOT NULL,
    mcat_cd smallint NOT NULL,
    scat_cd smallint NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_no character varying(10),
    keicho character(1),
    site_type character(1),
    check_type smallint,
    size text,
    remark text
);


ALTER TABLE public.item_sale OWNER TO postgres;

--
-- Name: card_group; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.card_group AS
 SELECT (max((
        CASE
            WHEN ((item_group_choice.item_group_key)::text = 'groupId'::text) THEN item_group_choice.value
            ELSE ''::character varying
        END)::text))::integer AS group_id,
    ''::character varying(12) AS group_cd,
    (max((
        CASE
            WHEN ((item_group_choice.item_group_key)::text = 'groupId'::text) THEN item_group_choice.name
            ELSE ''::character varying
        END)::text))::character varying(50) AS group_name,
    item_sale.item_cd,
    (max((
        CASE
            WHEN ((item_group_choice.item_group_key)::text = 'keichoMenuKbn'::text) THEN item_group_choice.value
            ELSE ''::character varying
        END)::text))::character varying(10) AS keicho_menu_kbn,
    (max((
        CASE
            WHEN ((item_group_choice.item_group_key)::text = 'verycardMenuKbn'::text) THEN item_group_choice.value
            ELSE ''::character varying
        END)::text))::character varying(20) AS verycard_menu_kbn
   FROM public.item_sale,
    public.item_group_choice,
    public.item_group_choice_link
  WHERE ((item_sale.lcat_cd = ANY (ARRAY[10, 20, 30, 50])) AND ((item_sale.item_cd)::text = (item_group_choice_link.item_cd)::text) AND (item_group_choice.item_group_choice_id = item_group_choice_link.item_group_choice_id) AND ((item_group_choice.item_group_key)::text = ANY (ARRAY[('groupId'::character varying)::text, ('keichoMenuKbn'::character varying)::text, ('verycardMenuKbn'::character varying)::text])))
  GROUP BY item_sale.item_cd;


ALTER TABLE public.card_group OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: card_group_bk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.card_group_bk (
    group_id integer NOT NULL,
    group_cd character varying(12) NOT NULL,
    group_name character varying(50) NOT NULL,
    item_cd character varying(10),
    keicho_menu_kbn character varying(10),
    verycard_menu_kbn character varying(20)
);


ALTER TABLE public.card_group_bk OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: item_site; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_site (
    item_site_id integer DEFAULT nextval(('item_site_id_seq'::text)::regclass) NOT NULL,
    sale_site character varying(20) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_nm character varying(80) NOT NULL,
    item_short character varying(80),
    head text,
    explan text,
    anno text,
    item_dsp_turn smallint,
    cost_price numeric(10,0),
    price numeric(10,0),
    general_price character varying(90),
    adjust_price numeric(10,0),
    margin real,
    margin_type smallint NOT NULL,
    prize boolean DEFAULT false NOT NULL,
    remark text,
    sale_status character(1) DEFAULT '0'::bpchar NOT NULL,
    reason text
);


ALTER TABLE public.item_site OWNER TO postgres;

--
-- Name: card_master; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.card_master AS
 SELECT item_sale.item_id AS card_id,
    (item_sale.item_cd)::character varying(12) AS card_number,
    (item_site.item_nm)::character varying(100) AS card_name,
    (item_group_choice.value)::integer AS group_id,
    (COALESCE(( SELECT
                CASE
                    WHEN (((item_sale.lcat_cd = 20) AND (item_sale.mcat_cd <> ALL (ARRAY[190, 280]))) OR (item_sale.lcat_cd = 30)) THEN item_site_1.adjust_price
                    ELSE item_site_1.price
                END AS price
           FROM public.item_site item_site_1
          WHERE (((item_sale.item_cd)::text = (item_site_1.item_cd)::text) AND ((item_site_1.sale_site)::text =
                CASE
                    WHEN (item_sale.mcat_cd = 260) THEN 'keicho.net'::text
                    WHEN (item_sale.lcat_cd = 50) THEN 'sagawa'::text
                    ELSE 'all'::text
                END))), (0)::numeric))::integer AS card_price1,
    (COALESCE(( SELECT
                CASE
                    WHEN (((item_sale.lcat_cd = 20) AND (item_sale.mcat_cd <> ALL (ARRAY[190, 280]))) OR (item_sale.lcat_cd = 30)) THEN item_site_1.adjust_price
                    ELSE item_site_1.price
                END AS price
           FROM public.item_site item_site_1
          WHERE (((item_sale.item_cd)::text = (item_site_1.item_cd)::text) AND ((item_site_1.sale_site)::text =
                CASE
                    WHEN (item_sale.mcat_cd = 260) THEN 'all'::text
                    ELSE 'verycard.net'::text
                END))), (0)::numeric))::integer AS card_price2,
    false AS youto_1,
    false AS youto_2,
    false AS youto_3,
    false AS youto_4,
    false AS youto_5,
    false AS youto_6,
    false AS youto_7,
    false AS youto_8,
    false AS youto_9,
    false AS youto_10,
        CASE
            WHEN ((2)::text = (item_sale.keicho)::text) THEN '0'::character varying(1)
            ELSE '1'::character varying(1)
        END AS card_flg,
    item_site.explan AS setumei,
    '1'::character varying(2) AS item_type,
        CASE
            WHEN ((0)::text = (item_site.sale_status)::text) THEN true
            ELSE false
        END AS enable,
    ''::text AS note
   FROM public.item_sale,
    public.item_site,
    public.item_group_choice,
    public.item_group_choice_link
  WHERE (((item_sale.item_cd)::text = (item_site.item_cd)::text) AND ((item_site.sale_site)::text =
        CASE
            WHEN (item_sale.lcat_cd = 50) THEN 'sagawa'::text
            ELSE 'all'::text
        END) AND (item_sale.lcat_cd = ANY (ARRAY[10, 20, 30, 50])) AND ((item_sale.item_cd)::text = (item_group_choice_link.item_cd)::text) AND (item_group_choice.item_group_choice_id = item_group_choice_link.item_group_choice_id) AND ((item_group_choice.item_group_key)::text = 'groupId'::text));


ALTER TABLE public.card_master OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: card_master_bk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.card_master_bk (
    card_id integer,
    card_number character varying(12),
    card_name character varying(100),
    group_id integer,
    card_price1 integer,
    card_price2 integer,
    youto_1 boolean,
    youto_2 boolean,
    youto_3 boolean,
    youto_4 boolean,
    youto_5 boolean,
    youto_6 boolean,
    youto_7 boolean,
    youto_8 boolean,
    youto_9 boolean,
    youto_10 boolean,
    card_flg character varying(1),
    setumei text,
    item_type character varying(2),
    enable boolean,
    note text
);


ALTER TABLE public.card_master_bk OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: cardcd; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cardcd (
    cardcd character varying(10),
    cardname character varying(60),
    cardtype character varying(2),
    youto_1 boolean,
    youto_2 boolean,
    youto_3 boolean,
    youto_4 boolean,
    youto_5 boolean,
    setumei text,
    enable boolean
);


ALTER TABLE public.cardcd OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: cart; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart (
    cartcd bigint,
    gift_type character varying(10),
    item_cate character varying(60),
    item_cd character varying(10),
    item_num smallint,
    item_name character varying(60),
    item_money integer,
    item_cnt smallint,
    opt_1 character varying(60),
    opt_2 character varying(60),
    opt_3 character varying(60),
    opt_4 character varying(60),
    opt_5 character varying(60),
    bikou text,
    date timestamp with time zone,
    jfn_7 character varying(60),
    opt_6 character varying(60),
    opt_7 character varying(60),
    opt_8 character varying(60),
    opt_9 character varying(60),
    opt_10 character varying(60),
    opt_11 character varying(60),
    opt_12 character varying(60)
);


ALTER TABLE public.cart OWNER TO postgres;

--
-- Name: cartcd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cartcd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cartcd_seq OWNER TO postgres;

--
-- Name: cc_tmp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cc_tmp (
    ccnum integer DEFAULT nextval(('"cc_tmp_ccnum_seq"'::text)::regclass) NOT NULL,
    time_1 timestamp with time zone,
    ck_kubun character varying(2),
    cred_num character varying(20),
    cred_name character varying(60),
    ord_kubun character varying(2),
    zeuscd integer,
    ordercd integer,
    ccid integer
);


ALTER TABLE public.cc_tmp OWNER TO postgres;

--
-- Name: cc_tmp_ccnum_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cc_tmp_ccnum_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cc_tmp_ccnum_seq OWNER TO postgres;

--
-- Name: change_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.change_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.change_id_seq OWNER TO postgres;

--
-- Name: class1_menu_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.class1_menu_tb (
    class1_menu_id character varying(3) NOT NULL,
    class1_menu text,
    flg character varying(1)
);


ALTER TABLE public.class1_menu_tb OWNER TO postgres;

--
-- Name: class2_menu_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.class2_menu_tb (
    class2_menu_id character varying(3) NOT NULL,
    class2_menu text,
    class1_menu_id character varying(3),
    flg character varying(1)
);


ALTER TABLE public.class2_menu_tb OWNER TO postgres;

--
-- Name: class3_menu_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.class3_menu_tb (
    class3_menu_id character varying(3) NOT NULL,
    class3_menu text,
    class1_menu_id character varying(3),
    class2_menu_id character varying(3),
    item_list text,
    flg character varying(1)
);


ALTER TABLE public.class3_menu_tb OWNER TO postgres;

--
-- Name: class_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.class_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.class_id_seq OWNER TO postgres;

--
-- Name: coid_price_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coid_price_master (
    coid character varying(12) NOT NULL,
    card_m integer,
    gift_m integer,
    flower_m integer,
    bikou text
);


ALTER TABLE public.coid_price_master OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: coidlist; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coidlist (
    f date,
    t date,
    coid character varying(255)
);


ALTER TABLE public.coidlist OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: column_category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.column_category (
    column_category_id integer DEFAULT nextval(('column_category_id_seq'::text)::regclass) NOT NULL,
    column_category_nm character varying(100) NOT NULL,
    parent_id integer,
    dir_name character varying(100) NOT NULL,
    explain text,
    meta_keywords character varying(100),
    meta_description text,
    meta_image_path text,
    disp_turn integer,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.column_category OWNER TO postgres;

--
-- Name: column_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.column_category_id_seq
    START WITH 30
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.column_category_id_seq OWNER TO postgres;

--
-- Name: column_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.column_data (
    column_data_id integer DEFAULT nextval(('column_data_id_seq'::text)::regclass) NOT NULL,
    column_category_id integer NOT NULL,
    file_name character varying(100) NOT NULL,
    title character varying(100) NOT NULL,
    content text,
    meta_keywords character varying(100),
    meta_description text,
    thumbnail_image_path text,
    release_date date NOT NULL,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.column_data OWNER TO postgres;

--
-- Name: column_data_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.column_data_id_seq
    START WITH 141
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.column_data_id_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: company_account_lock_stg; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_account_lock_stg (
    coid character varying(12) NOT NULL,
    status boolean DEFAULT false,
    update timestamp without time zone DEFAULT now(),
    owner integer NOT NULL
);


ALTER TABLE public.company_account_lock_stg OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: company_bill_destination; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_bill_destination (
    coid character varying(13) NOT NULL,
    bill_lcat_id integer NOT NULL,
    destination smallint NOT NULL
);


ALTER TABLE public.company_bill_destination OWNER TO postgres;

--
-- Name: company_general_account; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_general_account (
    coid character varying(13) NOT NULL,
    bank_account_id integer NOT NULL
);


ALTER TABLE public.company_general_account OWNER TO postgres;

--
-- Name: company_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_opt (
    coid character varying(13) NOT NULL,
    account_id_disabled boolean DEFAULT false NOT NULL,
    bill_carry_disabled boolean DEFAULT false NOT NULL,
    bill_pay_day character varying(2)
);


ALTER TABLE public.company_opt OWNER TO postgres;

--
-- Name: company_settle; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_settle (
    coid character varying(13) NOT NULL,
    orderid character(27),
    update_at timestamp without time zone DEFAULT now(),
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.company_settle OWNER TO postgres;

--
-- Name: company_special_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.company_special_type (
    coid character varying(13) NOT NULL,
    type smallint NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.company_special_type OWNER TO postgres;

--
-- Name: cs_template_cond; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cs_template_cond (
    cond_id integer DEFAULT nextval(('cs_template_cond_id_seq'::text)::regclass) NOT NULL,
    site character varying(20),
    channel_cd1 character varying(2),
    channel_cd2 character varying(2),
    q_lcat_cd character varying(5),
    q_mcat_cd character varying(5),
    q_scat_cd character varying(6)
);


ALTER TABLE public.cs_template_cond OWNER TO postgres;

--
-- Name: cs_template_cond_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cs_template_cond_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cs_template_cond_id_seq OWNER TO postgres;

--
-- Name: cs_template_cond_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cs_template_cond_link (
    tmpl_cond_link_id integer DEFAULT nextval(('tmpl_cond_link_id_seq'::text)::regclass) NOT NULL,
    link_type character varying(20),
    tmpl_id integer,
    cond_id integer
);


ALTER TABLE public.cs_template_cond_link OWNER TO postgres;

--
-- Name: cs_template_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cs_template_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cs_template_id_seq OWNER TO postgres;

--
-- Name: cs_template_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cs_template_master (
    tmpl_id integer DEFAULT nextval(('cs_template_id_seq'::text)::regclass) NOT NULL,
    tmpl_no character varying(10) NOT NULL,
    title character varying(30),
    note character varying(100),
    content text,
    ins_date timestamp with time zone,
    ins_usr_cd integer,
    ins_usr_name character varying(20),
    upd_date timestamp with time zone,
    upd_usr_id integer,
    upd_usr_name character varying(20),
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.cs_template_master OWNER TO postgres;

--
-- Name: ctalk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ctalk (
    ordercd integer,
    usertel character varying(15),
    limitdate timestamp with time zone,
    depo smallint,
    postdate timestamp with time zone,
    result boolean,
    alert timestamp with time zone
);


ALTER TABLE public.ctalk OWNER TO postgres;

--
-- Name: ctalk_voice; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ctalk_voice (
    zeuscd integer,
    ordercd integer,
    v_no character varying(8)
);


ALTER TABLE public.ctalk_voice OWNER TO postgres;

--
-- Name: cust_cd_num; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cust_cd_num (
    cust_cd_num_id integer DEFAULT nextval(('cust_cd_num_id_seq'::text)::regclass) NOT NULL,
    cust_cd character varying(12) NOT NULL
);


ALTER TABLE public.cust_cd_num OWNER TO postgres;

--
-- Name: cust_cd_num_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cust_cd_num_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.cust_cd_num_id_seq OWNER TO postgres;

--
-- Name: cust_cd_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cust_cd_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.cust_cd_num_seq OWNER TO postgres;

--
-- Name: custom_bun; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.custom_bun (
    buncd integer NOT NULL,
    cate_cd character varying(2),
    usercd integer,
    title character varying(40),
    text1 character varying(60),
    text2 character varying(60),
    text3 character varying(60),
    text4 character varying(60),
    text5 character varying(60),
    text6 character varying(60),
    text7 character varying(60),
    text8 character varying(60),
    text9 character varying(60),
    text10 character varying(60)
);


ALTER TABLE public.custom_bun OWNER TO postgres;

--
-- Name: d_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.d_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.d_cd_seq OWNER TO postgres;

--
-- Name: dead_stock_composition_results_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dead_stock_composition_results_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dead_stock_composition_results_id_seq OWNER TO postgres;

--
-- Name: dead_stock_results_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dead_stock_results_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dead_stock_results_id_seq OWNER TO postgres;

--
-- Name: del_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.del_order (
    ordercd integer NOT NULL,
    ordernum smallint,
    coid character varying(12),
    money1 integer,
    ag_1 character varying(12),
    ag_fee1 integer,
    ag_2 character varying(12),
    ag_fee2 integer,
    ag_3 character varying(12),
    ag_fee3 integer,
    del_date timestamp with time zone
);


ALTER TABLE public.del_order OWNER TO postgres;

--
-- Name: delivery_results_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.delivery_results_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.delivery_results_id_seq OWNER TO postgres;

--
-- Name: depo_barcode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_barcode (
    quest_id integer DEFAULT nextval(('quest_id_seq'::text)::regclass) NOT NULL,
    quest_type character(1) DEFAULT '0'::bpchar NOT NULL,
    target_cd integer NOT NULL,
    group_nm character varying(30),
    quest_num smallint NOT NULL,
    quest_min numeric(12,0) NOT NULL,
    quest_max numeric(12,0) NOT NULL,
    quest_recycle character(1) NOT NULL,
    quest_alarm numeric(12,0),
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.depo_barcode OWNER TO postgres;

--
-- Name: depo_barcode_used; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_barcode_used (
    quest_id integer NOT NULL,
    quest_now numeric(12,0),
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.depo_barcode_used OWNER TO postgres;

--
-- Name: depo_change_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.depo_change_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.depo_change_history_id_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: depo_change_pass_history_tbl; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_change_pass_history_tbl (
    depocd integer,
    old_password_1 character varying(255),
    old_password_2 character varying(255),
    change_date timestamp without time zone,
    owner character varying(255)
);


ALTER TABLE public.depo_change_pass_history_tbl OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: depo_change_pass_mst; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_change_pass_mst (
    start_date date NOT NULL,
    end_date date NOT NULL
);


ALTER TABLE public.depo_change_pass_mst OWNER TO postgres;

--
-- Name: depo_class; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_class (
    class_id integer DEFAULT nextval(('class_id_seq'::text)::regclass) NOT NULL,
    depocd_ctrl integer NOT NULL,
    depocd_act integer NOT NULL,
    disp_no smallint NOT NULL,
    update_type smallint NOT NULL,
    remark text,
    permit boolean DEFAULT false NOT NULL
);


ALTER TABLE public.depo_class OWNER TO postgres;

--
-- Name: depo_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depo_item (
    depo_item_id integer DEFAULT nextval(('depo_item_id_seq'::text)::regclass) NOT NULL,
    depocd integer NOT NULL,
    lcat_cd smallint NOT NULL,
    mcat_cd smallint NOT NULL,
    scat_cd smallint NOT NULL,
    leadtime smallint NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.depo_item OWNER TO postgres;

--
-- Name: depo_item_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.depo_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.depo_item_id_seq OWNER TO postgres;

--
-- Name: depo_transports_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.depo_transports_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.depo_transports_detail_id_seq OWNER TO postgres;

--
-- Name: depo_transports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.depo_transports_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.depo_transports_id_seq OWNER TO postgres;

--
-- Name: depocd; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.depocd (
    depocd integer NOT NULL,
    depo_class smallint NOT NULL,
    depo_type smallint NOT NULL,
    leadtime_unit character(1) NOT NULL,
    deponame character varying(60),
    c_name character varying(60),
    pass character varying(255),
    charge character varying(60),
    depo_pref smallint,
    depo_addr character varying(100),
    depo_tel character varying(15),
    depo_fax character varying(15),
    depo_mail character varying(50),
    remark text,
    start_at date,
    end_at date,
    regist_id integer,
    regist_at timestamp without time zone DEFAULT now(),
    update_id integer,
    update_at timestamp without time zone DEFAULT now(),
    stop boolean DEFAULT true NOT NULL,
    pass_org character varying(255),
    quest_id integer DEFAULT 0 NOT NULL,
    barcode_type character(1) DEFAULT '0'::bpchar,
    barcode_start_cd character(1),
    barcode_stop_cd character(1),
    barcode_check_sum character(1) DEFAULT '0'::bpchar,
    barcode_deliv_type character(1) DEFAULT '0'::bpchar,
    barcode_check_out character(1) DEFAULT '0'::bpchar,
    barcode_shime_prt smallint,
    barcode_shime_out smallint,
    barcode_shime_fin smallint,
    barcode_print boolean DEFAULT false,
    barcode_shime_base character(1) DEFAULT '0'::bpchar,
    barcode_note_fix text
);


ALTER TABLE public.depocd OWNER TO postgres;

--
-- Name: disable_lock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disable_lock (
    id integer NOT NULL,
    access_usercd character varying(120) NOT NULL,
    register integer NOT NULL,
    regist_date timestamp without time zone NOT NULL,
    update_date timestamp without time zone DEFAULT now(),
    site_type integer NOT NULL
);


ALTER TABLE public.disable_lock OWNER TO postgres;

--
-- Name: disable_lock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.disable_lock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.disable_lock_id_seq OWNER TO postgres;

--
-- Name: disable_lock_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.disable_lock_id_seq OWNED BY public.disable_lock.id;


SET default_with_oids = true;

--
-- Name: disp_custom; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.disp_custom (
    d_cd integer DEFAULT nextval(('d_cd_seq'::text)::regclass) NOT NULL,
    coid character varying(12) NOT NULL,
    sho1 boolean,
    sho2 boolean,
    sho3 boolean,
    sho4 boolean,
    sho5 boolean,
    sho6 boolean,
    sho7 boolean,
    sho8 boolean,
    sho9 boolean,
    sho10 boolean,
    sho11 boolean,
    sho12 boolean,
    sho13 boolean,
    sho14 boolean,
    sho15 boolean,
    sho16 boolean,
    sho17 boolean,
    sho18 boolean,
    sho19 boolean,
    sho20 boolean,
    sho21 boolean,
    sho22 boolean,
    sho23 boolean,
    sho24 boolean,
    sho25 boolean,
    sho26 boolean,
    sho27 boolean,
    sho28 boolean,
    sho29 boolean,
    sho30 boolean,
    d_bikou character varying(100),
    d_date timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone,
    enable boolean
);


ALTER TABLE public.disp_custom OWNER TO postgres;

--
-- Name: display_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.display_master (
    display_id integer NOT NULL,
    display_name character varying(120) NOT NULL,
    enable boolean NOT NULL,
    display_code character varying(120)
);


ALTER TABLE public.display_master OWNER TO postgres;

--
-- Name: display_master_display_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.display_master_display_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.display_master_display_id_seq OWNER TO postgres;

--
-- Name: display_master_display_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.display_master_display_id_seq OWNED BY public.display_master.display_id;


--
-- Name: enquete; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.enquete (
    e_cd character varying(5) NOT NULL,
    qa_num character varying(5) NOT NULL,
    q_1 character varying(400),
    q_2 character varying(400),
    q_3 character varying(400),
    q_4 character varying(400),
    q_5 character varying(400),
    q_6 character varying(400),
    q_7 character varying(400),
    q_8 character varying(400),
    q_9 character varying(400),
    q_10 character varying(400),
    q_11 character varying(400),
    q_12 character varying(400),
    q_13 character varying(400),
    q_14 character varying(400),
    q_15 character varying(400),
    q_16 character varying(400),
    q_17 character varying(400),
    q_18 character varying(400),
    q_19 character varying(400),
    q_20 character varying(400),
    q_21 character varying(400),
    q_22 character varying(400),
    q_23 character varying(400),
    q_24 character varying(400),
    q_25 character varying(400),
    q_26 character varying(400),
    q_27 character varying(400),
    q_28 character varying(400),
    q_29 character varying(400),
    q_30 character varying(400),
    qa_date timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone
);


ALTER TABLE public.enquete OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: es_pay; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.es_pay (
    noah_id character varying(12),
    d_type character varying(2),
    p_date date,
    money integer
);


ALTER TABLE public.es_pay OWNER TO postgres;

--
-- Name: faq; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.faq (
    fnum integer DEFAULT nextval(('"faq_fnum_seq"'::text)::regclass) NOT NULL,
    f_cate character varying(2),
    question text,
    answer text
);


ALTER TABLE public.faq OWNER TO postgres;

--
-- Name: faq_fnum_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.faq_fnum_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.faq_fnum_seq OWNER TO postgres;

--
-- Name: fast_deliv_mng; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fast_deliv_mng (
    fast_deliv_mng_id integer DEFAULT nextval(('fast_deliv_mng_id_seq'::text)::regclass) NOT NULL,
    title character varying(60),
    ceremony smallint,
    a_date_start date,
    a_date_end date,
    print_date date,
    print_time smallint,
    tantou character varying(30),
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.fast_deliv_mng OWNER TO postgres;

--
-- Name: fast_deliv_mng_c_use; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fast_deliv_mng_c_use (
    fast_deliv_mng_id integer NOT NULL,
    c_use smallint NOT NULL,
    c_other character varying(60)
);


ALTER TABLE public.fast_deliv_mng_c_use OWNER TO postgres;

--
-- Name: fast_deliv_mng_depocd; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fast_deliv_mng_depocd (
    fast_deliv_mng_id integer NOT NULL,
    depocd integer NOT NULL
);


ALTER TABLE public.fast_deliv_mng_depocd OWNER TO postgres;

--
-- Name: fast_deliv_mng_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fast_deliv_mng_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.fast_deliv_mng_id_seq OWNER TO postgres;

--
-- Name: from_smbc; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.from_smbc (
    id integer DEFAULT nextval(('from_smbc_seq'::text)::regclass),
    version character(3),
    bill_method character(2),
    bill_method_name character varying(50),
    kessai_id character(4),
    kessai_name character varying(50),
    shop_cd character(7),
    syuno_co_cd character varying(8),
    kyoten_cd character varying(8),
    shoporder_no character(17),
    seikyuu_kingaku integer,
    kessai_date character(8),
    kessai_time character(6),
    kessai_no character(14),
    shiharai_date character(8),
    shiharai_time character(4),
    haraidashi_no1 character varying(256),
    haraidashi_no2 character varying(256),
    haraidashi_no3 character varying(256),
    rescd character(6),
    res character varying(256)
);


ALTER TABLE public.from_smbc OWNER TO postgres;

--
-- Name: from_smbc_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.from_smbc_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.from_smbc_seq OWNER TO postgres;

--
-- Name: fromname; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fromname (
    fromcd integer NOT NULL,
    usercd integer NOT NULL,
    from1 character varying(60),
    from2 character varying(60),
    from3 character varying(60),
    from4 character varying(60),
    title character varying(40)
);


ALTER TABLE public.fromname OWNER TO postgres;

--
-- Name: giftcd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.giftcd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.giftcd_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: gmo_err; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gmo_err (
    shoporder_no character(27),
    sendid integer,
    tenantno character varying(2),
    money integer,
    errinfo character varying(60),
    errmsg text,
    err_date character(8),
    err_time character(8),
    accessid character(32),
    accesspass character(32),
    u_agent text
);


ALTER TABLE public.gmo_err OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: gmo_res; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gmo_res (
    sendid integer NOT NULL,
    accessid character varying(32),
    accesspass character varying(32),
    tranid character varying(100),
    trandate timestamp with time zone,
    tenantno character varying(2),
    amount integer,
    method character varying(2),
    paytimes character varying(2),
    forward character varying(15),
    approve character varying(7),
    ordercd integer,
    orderid character(27),
    checkstring character(32),
    veritrans_response text
);


ALTER TABLE public.gmo_res OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: gmo_sys_errinfo_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gmo_sys_errinfo_tb (
    errcode character varying(60),
    errinfo character varying(60) NOT NULL,
    errmsg text
);


ALTER TABLE public.gmo_sys_errinfo_tb OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: gp_err; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gp_err (
    errcode character varying(4),
    errinfo character varying(20),
    errname character varying(60),
    errtype character varying(2),
    comment character varying(200),
    userinfo boolean
);


ALTER TABLE public.gp_err OWNER TO postgres;

--
-- Name: h_bikou; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.h_bikou (
    coid character varying(12) NOT NULL,
    h_bikou1 text,
    h_bikou2 text,
    h_bikou3 text
);


ALTER TABLE public.h_bikou OWNER TO postgres;

--
-- Name: h_dep; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.h_dep (
    d_code integer NOT NULL,
    d_name character varying(40) NOT NULL,
    g_code integer DEFAULT 0 NOT NULL,
    g_name character varying(40)
);


ALTER TABLE public.h_dep OWNER TO postgres;

--
-- Name: h_order_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.h_order_item (
    h_ordercd integer NOT NULL,
    h_ordernum smallint NOT NULL,
    item_type character varying(2) NOT NULL,
    h_money1 integer,
    item_cd character varying(10),
    attr_1 character varying(60),
    attr_2 character varying(60),
    attr_3 character varying(60),
    attr_4 character varying(60),
    attr_5 character varying(60),
    attr_6 character varying(60),
    attr_7 character varying(60),
    attr_8 character varying(60),
    attr_9 character varying(60),
    attr_10 character varying(60),
    attr_11 character varying(60),
    attr_12 character varying(60),
    attr_13 character varying(60),
    attr_14 character varying(60),
    attr_15 character varying(60),
    attr_16 character varying(60),
    attr_17 character varying(60),
    attr_18 character varying(60),
    attr_19 character varying(60),
    attr_20 character varying(60),
    attr_21 character varying(60),
    attr_22 character varying(60)
);


ALTER TABLE public.h_order_item OWNER TO postgres;

--
-- Name: h_order_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.h_order_master (
    h_ordercd integer NOT NULL,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    bikou character varying(60),
    h_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(10),
    r_ordercd integer DEFAULT 0,
    renkei_id character varying(256),
    chuumon_id character varying(256),
    syukka_id character varying(256),
    noah_id character varying(12)
);


ALTER TABLE public.h_order_master OWNER TO postgres;

--
-- Name: h_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.h_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.h_ordercd_seq OWNER TO postgres;

--
-- Name: h_shain; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.h_shain (
    e_code integer,
    name1 character varying(20),
    name2 character varying(20),
    kana1 character varying(30),
    kana2 character varying(30),
    sex character varying(1),
    b_date date,
    s_date date,
    e_date date,
    act_code character varying(1),
    class_code character varying(2),
    d_code integer,
    class_name character varying(40),
    w_place character varying(2),
    zip_code character varying(8),
    pref smallint,
    address character varying(200),
    tel1 character varying(15),
    tel2 character varying(15),
    mail character varying(50),
    pass character varying(255),
    al_1 boolean,
    al_2 boolean,
    al_3 boolean,
    al_4 boolean,
    al_5 boolean,
    mail2 character varying(50),
    u_date date,
    mobile_schedule_flg boolean,
    pass_org character varying(255),
    schedule_flg boolean
);


ALTER TABLE public.h_shain OWNER TO postgres;

--
-- Name: hikiotoshi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hikiotoshi (
    coid character varying(13) NOT NULL,
    tantou character varying(60),
    date_1 timestamp with time zone,
    date_2 timestamp with time zone,
    date_3 timestamp with time zone,
    ck_hiki boolean,
    q_code character varying(20),
    bank_cd character(4),
    branch_cd character(3),
    acc_kind character(1),
    acc_no character(7),
    acc_nm character varying(30),
    acc_kana character varying(30),
    acc_status character(1),
    update_at timestamp without time zone,
    remark text
);


ALTER TABLE public.hikiotoshi OWNER TO postgres;

--
-- Name: hist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hist_id_seq OWNER TO postgres;

--
-- Name: hitachi_login; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hitachi_login (
    sessid character varying(30) NOT NULL,
    sess_date timestamp with time zone,
    status character varying(10),
    pl_id character varying(100)
);


ALTER TABLE public.hitachi_login OWNER TO postgres;

--
-- Name: humony_adm_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.humony_adm_log (
    log_num integer DEFAULT nextval(('adm_log_seq'::text)::regclass) NOT NULL,
    e_code smallint,
    login_ip cidr,
    login_time timestamp with time zone DEFAULT now(),
    logout_time timestamp with time zone
);


ALTER TABLE public.humony_adm_log OWNER TO postgres;

--
-- Name: income; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.income (
    in_cd integer DEFAULT nextval(('income_cd_seq'::text)::regclass),
    ms_num character varying(6),
    in_date date,
    in_money integer,
    account integer,
    sck_cd integer DEFAULT 0,
    s_cd integer DEFAULT 0,
    s_type character(1) DEFAULT '0'::bpchar,
    bank_code character varying(4) DEFAULT ''::character varying,
    payments_name character varying(60) DEFAULT ''::character varying,
    vone_invoice_seqno character varying(20),
    vone_payment_seqno character varying(20)
);


ALTER TABLE public.income OWNER TO postgres;

--
-- Name: income_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.income_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.income_cd_seq OWNER TO postgres;

--
-- Name: income_cedyna; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.income_cedyna (
    in_cd integer DEFAULT nextval(('income_cedyna_cd_seq'::text)::regclass) NOT NULL,
    q_code character varying(20) NOT NULL,
    in_date_trans date NOT NULL,
    in_date date NOT NULL,
    in_money integer,
    bank_cd character(4),
    branch_cd character(3),
    acc_kind character(1),
    acc_no character(7),
    acc_nm character varying(30),
    acc_kana character varying(30),
    status character(1) NOT NULL,
    s_cd integer DEFAULT 0
);


ALTER TABLE public.income_cedyna OWNER TO postgres;

--
-- Name: income_cedyna_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.income_cedyna_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.income_cedyna_cd_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: incomplete_coidlist; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.incomplete_coidlist (
    f date,
    t date,
    coid character varying(255)
);


ALTER TABLE public.incomplete_coidlist OWNER TO postgres;

--
-- Name: info_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.info_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.info_id_seq OWNER TO postgres;

--
-- Name: info_info_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.info_info_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.info_info_cd_seq OWNER TO postgres;

--
-- Name: information_board; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.information_board (
    info_id integer DEFAULT nextval(('info_id_seq'::text)::regclass) NOT NULL,
    info_category character varying(20),
    info_title character varying(15),
    info_summary character varying(50),
    info_detail character varying(400),
    member_id character varying(4),
    info_startdate timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL,
    info_limit character varying(2),
    info_limitdate timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL,
    entry_date timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone NOT NULL,
    permit_flg boolean DEFAULT true NOT NULL
);


ALTER TABLE public.information_board OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: intro; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.intro (
    intro_id character varying(12) NOT NULL,
    intro_name character varying(60),
    addr1 smallint,
    addr2 character varying(100),
    i_tel character varying(15),
    i_mail character varying(50),
    card_m smallint,
    opt_m smallint,
    gcat_m smallint,
    org_id character varying(12),
    tiger_m smallint
);


ALTER TABLE public.intro OWNER TO postgres;

--
-- Name: io_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.io_master (
    io_code character varying(20) NOT NULL,
    io_date date,
    nouhin character varying(100),
    syukka_cd character varying(20),
    syukka_fee integer DEFAULT 0,
    sousin date
);


ALTER TABLE public.io_master OWNER TO postgres;

--
-- Name: io_meisai; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.io_meisai (
    io_code character varying(20) NOT NULL,
    s_code character varying(10),
    i_cnt smallint DEFAULT 0,
    i_total integer DEFAULT 0
);


ALTER TABLE public.io_meisai OWNER TO postgres;

--
-- Name: ishop_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ishop_item (
    h_ordercd integer NOT NULL,
    h_ordernum smallint NOT NULL,
    item_type character varying(2) NOT NULL,
    h_money1 integer,
    item_cd character varying(10),
    attr_1 character varying(60),
    attr_2 character varying(60),
    attr_3 character varying(60),
    attr_4 character varying(60),
    attr_5 character varying(60),
    attr_6 character varying(60),
    attr_7 character varying(60),
    attr_8 character varying(60),
    attr_9 character varying(60),
    attr_10 character varying(60),
    attr_11 character varying(60),
    attr_12 character varying(60),
    attr_13 character varying(60),
    attr_14 character varying(60),
    attr_15 character varying(60),
    attr_16 character varying(60),
    attr_17 character varying(60),
    attr_18 character varying(60),
    attr_19 character varying(60),
    attr_20 character varying(60),
    attr_21 character varying(60),
    attr_22 character varying(60)
);


ALTER TABLE public.ishop_item OWNER TO postgres;

--
-- Name: ishop_login; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ishop_login (
    sessid character varying(30),
    sess_date timestamp with time zone,
    status character varying(10),
    pl_id character varying(100),
    userid character varying(20)
);


ALTER TABLE public.ishop_login OWNER TO postgres;

--
-- Name: ishop_omas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ishop_omas (
    h_ordercd integer NOT NULL,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    bikou character varying(60),
    h_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(10),
    r_ordercd integer DEFAULT 0,
    renkei_id character varying(256),
    chuumon_id character varying(256),
    syukka_id character varying(256),
    noah_id character varying(12),
    user_id character varying(20)
);


ALTER TABLE public.ishop_omas OWNER TO postgres;

--
-- Name: ishop_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ishop_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ishop_ordercd_seq OWNER TO postgres;

--
-- Name: issei_mail_i_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.issei_mail_i_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.issei_mail_i_num_seq OWNER TO postgres;

--
-- Name: item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item (
    itemnum integer,
    item_cd character varying(10),
    item_type character varying(10),
    item_name character varying(60),
    item_cate character varying(10),
    item_money integer,
    item_money2 integer,
    siire_money integer,
    siire_code character varying(12),
    item_bikou text
);


ALTER TABLE public.item OWNER TO postgres;

--
-- Name: item_addition; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_addition (
    item_addition_id integer DEFAULT nextval(('item_addition_id_seq'::text)::regclass) NOT NULL,
    item_addition_key character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_addition OWNER TO postgres;

--
-- Name: item_addition_choice; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_addition_choice (
    item_addition_choice_id integer DEFAULT nextval(('item_addition_choice_id_seq'::text)::regclass) NOT NULL,
    item_addition_key character varying(255) NOT NULL,
    value character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    dsp_turn integer NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_addition_choice OWNER TO postgres;

--
-- Name: item_addition_choice_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_addition_choice_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_addition_choice_id_seq OWNER TO postgres;

--
-- Name: item_addition_choice_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_addition_choice_link (
    item_addition_choice_link_id integer DEFAULT nextval(('item_addition_choice_link_id_seq'::text)::regclass) NOT NULL,
    sale_site character varying(20) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_addition_choice_id integer NOT NULL,
    dsp_turn integer NOT NULL
);


ALTER TABLE public.item_addition_choice_link OWNER TO postgres;

--
-- Name: item_addition_choice_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_addition_choice_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_addition_choice_link_id_seq OWNER TO postgres;

--
-- Name: item_addition_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_addition_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_addition_id_seq OWNER TO postgres;

--
-- Name: item_addition_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_addition_link (
    item_addition_link_id integer DEFAULT nextval(('item_addition_link_id_seq'::text)::regclass) NOT NULL,
    sale_site character varying(20) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_addition_key character varying(255) NOT NULL,
    value character varying(255),
    date_start timestamp without time zone,
    date_end timestamp without time zone
);


ALTER TABLE public.item_addition_link OWNER TO postgres;

--
-- Name: item_addition_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_addition_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_addition_link_id_seq OWNER TO postgres;

--
-- Name: item_opt_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_opt_link (
    item_opt_link_id integer DEFAULT nextval(('item_opt_link_id_seq'::text)::regclass) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_opt_key character varying(255) NOT NULL
);


ALTER TABLE public.item_opt_link OWNER TO postgres;

--
-- Name: item_set_main; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_set_main (
    item_set_main_id integer DEFAULT nextval(('item_set_main_id_seq'::text)::regclass) NOT NULL,
    item_set_key character varying(255) NOT NULL,
    item_cd character varying(10) NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_set_main OWNER TO postgres;

--
-- Name: item_set_sub; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_set_sub (
    item_set_sub_id integer DEFAULT nextval(('item_set_sub_id_seq'::text)::regclass) NOT NULL,
    sale_site character varying(20) NOT NULL,
    item_set_main_id integer NOT NULL,
    item_cd character varying(10) NOT NULL,
    dsp_turn integer NOT NULL
);


ALTER TABLE public.item_set_sub OWNER TO postgres;

--
-- Name: item_all; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.item_all AS
 SELECT item_sale.item_id,
    item_sale.lcat_cd,
    item_sale.mcat_cd,
    item_sale.scat_cd,
    '1'::character(1) AS item_type,
    item_sale.item_cd,
    item_sale.item_no,
    item_site.item_nm,
    item_site.item_short,
    item_site.head,
    item_site.explan,
    item_site.anno,
    item_sale.keicho,
    '0'::character(1) AS card,
    item_site.item_dsp_turn,
    item_sale.site_type,
        CASE
            WHEN (EXISTS ( SELECT item_set_main.item_set_main_id,
                item_set_main.item_set_key,
                item_set_main.item_cd,
                item_set_main.permit,
                item_set_sub.item_set_sub_id,
                item_set_sub.sale_site,
                item_set_sub.item_set_main_id,
                item_set_sub.item_cd,
                item_set_sub.dsp_turn
               FROM public.item_set_main,
                public.item_set_sub
              WHERE ((item_set_main.item_set_main_id = item_set_sub.item_set_main_id) AND ((item_set_main.item_cd)::text = 'surprise'::text) AND ((item_set_sub.item_cd)::text = (item_sale.item_cd)::text)))) THEN true
            ELSE false
        END AS com_sp,
        CASE
            WHEN (EXISTS ( SELECT item_opt_link.item_opt_link_id,
                item_opt_link.item_cd,
                item_opt_link.item_opt_key
               FROM public.item_opt_link
              WHERE (((item_sale.item_cd)::text = (item_opt_link.item_cd)::text) AND ((item_opt_link.item_opt_key)::text = 'time'::text)))) THEN true
            ELSE false
        END AS com_time,
        CASE
            WHEN (EXISTS ( SELECT item_opt_link.item_opt_link_id,
                item_opt_link.item_cd,
                item_opt_link.item_opt_key
               FROM public.item_opt_link
              WHERE (((item_sale.item_cd)::text = (item_opt_link.item_cd)::text) AND ((item_opt_link.item_opt_key)::text = 'cool'::text)))) THEN true
            ELSE false
        END AS com_cool,
        CASE
            WHEN (EXISTS ( SELECT item_opt_link.item_opt_link_id,
                item_opt_link.item_cd,
                item_opt_link.item_opt_key
               FROM public.item_opt_link
              WHERE (((item_sale.item_cd)::text = (item_opt_link.item_cd)::text) AND ((item_opt_link.item_opt_key)::text = 'hall'::text)))) THEN true
            ELSE false
        END AS com_hall,
    item_sale.check_type,
    ''::character varying(20) AS color,
    (0)::smallint AS rinsu,
    (item_sale.size)::character varying(20) AS size,
    item_site.cost_price,
    (COALESCE(( SELECT
                CASE
                    WHEN (((item_sale.lcat_cd = 20) AND (item_sale.mcat_cd <> ALL (ARRAY[190, 280]))) OR (item_sale.lcat_cd = 30)) THEN item_site_1.adjust_price
                    ELSE item_site_1.price
                END AS price
           FROM public.item_site item_site_1
          WHERE (((item_sale.item_cd)::text = (item_site_1.item_cd)::text) AND ((item_site_1.sale_site)::text =
                CASE
                    WHEN (item_sale.mcat_cd = 260) THEN 'all'::text
                    ELSE 'verycard.net'::text
                END))), (0)::numeric))::numeric(10,0) AS price_verycard,
    (COALESCE(( SELECT
                CASE
                    WHEN (((item_sale.lcat_cd = 20) AND (item_sale.mcat_cd <> ALL (ARRAY[190, 280]))) OR (item_sale.lcat_cd = 30)) THEN item_site_1.adjust_price
                    ELSE item_site_1.price
                END AS price
           FROM public.item_site item_site_1
          WHERE (((item_sale.item_cd)::text = (item_site_1.item_cd)::text) AND ((item_site_1.sale_site)::text =
                CASE
                    WHEN (item_sale.mcat_cd = 260) THEN 'keicho.net'::text
                    WHEN (item_sale.lcat_cd = 50) THEN 'sagawa'::text
                    ELSE 'all'::text
                END))), (0)::numeric))::numeric(10,0) AS price_keicho,
    item_site.general_price,
    (COALESCE(( SELECT item_addition_link.value
           FROM public.item_addition_link
          WHERE (((item_sale.item_cd)::text = (item_addition_link.item_cd)::text) AND ((item_addition_link.item_addition_key)::text = 'voiceType'::text))), '0'::character varying))::character(1) AS voice_type,
    item_site.sale_status,
    item_site.reason,
    item_sale.remark,
    item_site.prize
   FROM public.item_sale,
    public.item_site
  WHERE (((item_sale.item_cd)::text = (item_site.item_cd)::text) AND ((item_site.sale_site)::text =
        CASE
            WHEN (item_sale.lcat_cd = 50) THEN 'sagawa'::text
            ELSE 'all'::text
        END));


ALTER TABLE public.item_all OWNER TO postgres;

--
-- Name: item_all_bk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_all_bk (
    item_id integer DEFAULT nextval(('item_id_seq'::text)::regclass) NOT NULL,
    lcat_cd smallint NOT NULL,
    mcat_cd smallint NOT NULL,
    scat_cd smallint NOT NULL,
    item_type character(1) NOT NULL,
    item_cd character varying(10) NOT NULL,
    item_no character varying(10),
    item_nm character varying(80) NOT NULL,
    item_short character varying(80),
    head text,
    explan text,
    anno text,
    keicho character(1),
    card character(1),
    item_dsp_turn smallint,
    site_type character(1),
    com_sp boolean,
    com_time boolean,
    com_cool boolean,
    com_hall boolean,
    check_type smallint,
    color character varying(20),
    rinsu smallint,
    size character varying(20),
    cost_price numeric(10,0),
    price_verycard numeric(10,0),
    price_keicho numeric(10,0),
    general_price character varying(90),
    voice_type character(1),
    sale_status character(1) DEFAULT '0'::bpchar NOT NULL,
    reason text,
    remark text,
    prize boolean DEFAULT false NOT NULL
);


ALTER TABLE public.item_all_bk OWNER TO postgres;

--
-- Name: item_composition_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_composition_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.item_composition_master_id_seq OWNER TO postgres;

--
-- Name: item_composition_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_composition_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.item_composition_stock_id_seq OWNER TO postgres;

--
-- Name: item_count; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_count (
    card_id integer NOT NULL,
    item_type character varying(2),
    cardcd character varying(6),
    item_cd character varying(10),
    flg character varying(15),
    count character varying(5),
    start_date date,
    msg_txt character varying(200),
    enable boolean
);


ALTER TABLE public.item_count OWNER TO postgres;

--
-- Name: item_filter_coid; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_filter_coid (
    item_filter_coid_id integer DEFAULT nextval(('item_filter_coid_id_seq'::text)::regclass) NOT NULL,
    coid character varying(16) NOT NULL,
    e_code integer NOT NULL,
    view_flg smallint NOT NULL,
    permit boolean NOT NULL,
    note text
);


ALTER TABLE public.item_filter_coid OWNER TO postgres;

--
-- Name: item_filter_coid_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_filter_coid_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_filter_coid_id_seq OWNER TO postgres;

--
-- Name: item_filter_ex; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_filter_ex (
    item_filter_ex_id integer DEFAULT nextval(('item_filter_ex_id_seq'::text)::regclass) NOT NULL,
    item_filter_coid_id integer NOT NULL,
    item_cd character varying(20) NOT NULL
);


ALTER TABLE public.item_filter_ex OWNER TO postgres;

--
-- Name: item_filter_ex_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_filter_ex_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_filter_ex_id_seq OWNER TO postgres;

--
-- Name: item_filter_price; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_filter_price (
    item_filter_price_id integer DEFAULT nextval(('item_filter_price_id_seq'::text)::regclass) NOT NULL,
    item_filter_coid_id integer NOT NULL,
    item_group_choice_id integer NOT NULL,
    low_limit_price integer,
    high_limit_price integer
);


ALTER TABLE public.item_filter_price OWNER TO postgres;

--
-- Name: item_filter_price_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_filter_price_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_filter_price_id_seq OWNER TO postgres;

--
-- Name: item_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_group (
    item_group_id integer DEFAULT nextval(('item_group_id_seq'::text)::regclass) NOT NULL,
    item_group_key character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_group OWNER TO postgres;

--
-- Name: item_group_choice_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_group_choice_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_group_choice_id_seq OWNER TO postgres;

--
-- Name: item_group_choice_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_group_choice_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_group_choice_link_id_seq OWNER TO postgres;

--
-- Name: item_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_group_id_seq OWNER TO postgres;

--
-- Name: item_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_id_seq OWNER TO postgres;

--
-- Name: item_lcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_lcat (
    lcat_id integer DEFAULT nextval(('lcat_id_seq'::text)::regclass) NOT NULL,
    lcat_cd smallint NOT NULL,
    lcat_nm character varying(30) NOT NULL,
    item_dsp_turn smallint,
    head text,
    explan text,
    anno text,
    lbanner_img character varying(255),
    lbanner_text character varying(90),
    sbanner_img character varying(255),
    sbanner_text character varying(90),
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.item_lcat OWNER TO postgres;

--
-- Name: item_mcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_mcat (
    mcat_id integer DEFAULT nextval(('mcat_id_seq'::text)::regclass) NOT NULL,
    lcat_cd smallint NOT NULL,
    mcat_cd smallint NOT NULL,
    mcat_nm character varying(30) NOT NULL,
    item_dsp_turn smallint,
    head text,
    explan text,
    anno text,
    lbanner_img character varying(255),
    lbanner_text character varying(90),
    sbanner_img character varying(255),
    sbanner_text character varying(90),
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.item_mcat OWNER TO postgres;

--
-- Name: item_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_opt (
    item_opt_id integer DEFAULT nextval(('item_opt_id_seq'::text)::regclass) NOT NULL,
    item_opt_key character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_opt OWNER TO postgres;

--
-- Name: item_opt_choice; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_opt_choice (
    item_opt_choice_id integer DEFAULT nextval(('item_opt_choice_id_seq'::text)::regclass) NOT NULL,
    item_opt_key character varying(255) NOT NULL,
    value character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    price integer NOT NULL,
    dsp_turn integer NOT NULL,
    permit boolean NOT NULL
);


ALTER TABLE public.item_opt_choice OWNER TO postgres;

--
-- Name: item_opt_choice_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_opt_choice_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_opt_choice_id_seq OWNER TO postgres;

--
-- Name: item_opt_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_opt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_opt_id_seq OWNER TO postgres;

--
-- Name: item_opt_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_opt_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_opt_link_id_seq OWNER TO postgres;

--
-- Name: item_ranking; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_ranking (
    scat_cd smallint NOT NULL,
    rank smallint NOT NULL,
    item_cd character varying(10) NOT NULL,
    option character varying(10)
);


ALTER TABLE public.item_ranking OWNER TO postgres;

--
-- Name: item_scat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_scat (
    scat_id integer DEFAULT nextval(('scat_id_seq'::text)::regclass) NOT NULL,
    lcat_cd smallint NOT NULL,
    mcat_cd smallint NOT NULL,
    scat_cd smallint NOT NULL,
    scat_nm character varying(30) NOT NULL,
    item_dsp_turn smallint,
    area_unit character(1),
    remark text,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.item_scat OWNER TO postgres;

--
-- Name: item_set; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_set (
    item_set_id integer DEFAULT nextval(('item_set_id_seq'::text)::regclass) NOT NULL,
    item_set_key character varying(255) NOT NULL,
    name character varying(255),
    permit boolean NOT NULL
);


ALTER TABLE public.item_set OWNER TO postgres;

--
-- Name: item_set_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_set_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_set_id_seq OWNER TO postgres;

--
-- Name: item_set_main_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_set_main_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_set_main_id_seq OWNER TO postgres;

--
-- Name: item_set_sub_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_set_sub_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_set_sub_id_seq OWNER TO postgres;

--
-- Name: item_site_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.item_site_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.item_site_id_seq OWNER TO postgres;

--
-- Name: item_type_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.item_type_master (
    item_type character varying(2) NOT NULL,
    item_type_name character varying(30) NOT NULL
);


ALTER TABLE public.item_type_master OWNER TO postgres;

--
-- Name: jb_nouhin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jb_nouhin (
    nouhin_cd integer DEFAULT nextval(('jb_nouhin_cd_seq'::text)::regclass),
    n_usercd integer NOT NULL,
    n_post character varying(7),
    n_pref character varying(2),
    n_siku character varying(40),
    n_tyou character varying(100),
    n_addr character varying(100),
    n_build character varying(100),
    n_cname character varying(60),
    n_name character varying(60),
    n_tel character varying(15)
);


ALTER TABLE public.jb_nouhin OWNER TO postgres;

--
-- Name: jb_nouhin_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jb_nouhin_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jb_nouhin_cd_seq OWNER TO postgres;

--
-- Name: jiscode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jiscode (
    jiscode character varying(5),
    pref smallint,
    chimei character varying(40),
    hana character varying(2),
    alpha character varying(2),
    gift character varying(2),
    tiger character varying(2),
    arrange character varying(2),
    jb character varying(2),
    wanwan character varying(2),
    medal character varying(2)
);


ALTER TABLE public.jiscode OWNER TO postgres;

--
-- Name: jp_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_item (
    h_ordercd integer NOT NULL,
    h_ordernum smallint NOT NULL,
    item_type character varying(2) NOT NULL,
    h_money1 integer,
    item_cd character varying(10),
    attr_1 character varying(60),
    attr_2 character varying(60),
    attr_3 character varying(60),
    attr_4 character varying(60),
    attr_5 character varying(60),
    attr_6 character varying(60),
    attr_7 character varying(60),
    attr_8 character varying(60),
    attr_9 character varying(60),
    attr_10 character varying(60),
    attr_11 character varying(60),
    attr_12 character varying(60),
    attr_13 character varying(60),
    attr_14 character varying(60),
    attr_15 character varying(60),
    attr_16 character varying(60),
    attr_17 character varying(60),
    attr_18 character varying(60),
    attr_19 character varying(60),
    attr_20 character varying(60),
    attr_21 character varying(60),
    attr_22 character varying(60)
);


ALTER TABLE public.jp_item OWNER TO postgres;

--
-- Name: jp_item_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_item_test (
    h_ordercd integer NOT NULL,
    h_ordernum smallint NOT NULL,
    item_type character varying(2) NOT NULL,
    h_money1 integer,
    item_cd character varying(10),
    attr_1 character varying(60),
    attr_2 character varying(60),
    attr_3 character varying(60),
    attr_4 character varying(60),
    attr_5 character varying(60),
    attr_6 character varying(60),
    attr_7 character varying(60),
    attr_8 character varying(60),
    attr_9 character varying(60),
    attr_10 character varying(60),
    attr_11 character varying(60),
    attr_12 character varying(60),
    attr_13 character varying(60),
    attr_14 character varying(60),
    attr_15 character varying(60),
    attr_16 character varying(60),
    attr_17 character varying(60),
    attr_18 character varying(60),
    attr_19 character varying(60),
    attr_20 character varying(60),
    attr_21 character varying(60),
    attr_22 character varying(60)
);


ALTER TABLE public.jp_item_test OWNER TO postgres;

--
-- Name: jp_login; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_login (
    sessid character varying(30) NOT NULL,
    sess_date timestamp with time zone,
    status character varying(10),
    pl_id character varying(100),
    userid character varying(20)
);


ALTER TABLE public.jp_login OWNER TO postgres;

--
-- Name: jp_login_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_login_test (
    sessid character varying(30) NOT NULL,
    sess_date timestamp with time zone,
    status character varying(10),
    pl_id character varying(100),
    userid character varying(20)
);


ALTER TABLE public.jp_login_test OWNER TO postgres;

--
-- Name: jp_omas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_omas (
    h_ordercd integer NOT NULL,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    bikou character varying(60),
    h_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(10),
    r_ordercd integer DEFAULT 0,
    renkei_id character varying(256),
    chuumon_id character varying(256),
    syukka_id character varying(256),
    noah_id character varying(12),
    user_id character varying(20)
);


ALTER TABLE public.jp_omas OWNER TO postgres;

--
-- Name: jp_omas_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jp_omas_test (
    h_ordercd integer NOT NULL,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    bikou character varying(60),
    h_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(10),
    r_ordercd integer DEFAULT 0,
    renkei_id character varying(256),
    chuumon_id character varying(256),
    syukka_id character varying(256),
    noah_id character varying(12),
    user_id character varying(20)
);


ALTER TABLE public.jp_omas_test OWNER TO postgres;

--
-- Name: jp_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jp_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jp_ordercd_seq OWNER TO postgres;

--
-- Name: jp_test_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jp_test_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jp_test_ordercd_seq OWNER TO postgres;

--
-- Name: k_gyousya; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.k_gyousya (
    g_cd integer NOT NULL,
    g_name character varying(100),
    g_post character varying(8),
    g_pref character varying(8),
    g_addr character varying(100),
    g_build character varying(100),
    g_tantou character varying(60),
    g_tel character varying(15),
    g_fax character varying(15),
    g_mail character varying(50),
    bikou character varying(100),
    attr_1 character varying(10),
    attr_2 character varying(60),
    attr_3 character varying(60),
    g_bank character varying(60),
    g_siten character varying(60),
    g_syubetu character varying(2),
    g_acnum character varying(20),
    g_acname character varying(60)
);


ALTER TABLE public.k_gyousya OWNER TO postgres;

--
-- Name: k_himoku; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.k_himoku (
    himoku_cd smallint NOT NULL,
    himoku_name character varying(60),
    siwake_cd smallint NOT NULL
);


ALTER TABLE public.k_himoku OWNER TO postgres;

--
-- Name: k_issei_mail_i_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.k_issei_mail_i_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.k_issei_mail_i_num_seq OWNER TO postgres;

--
-- Name: k_siire_d; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.k_siire_d (
    siire_cd integer NOT NULL,
    siire_num smallint NOT NULL,
    himoku_cd smallint,
    tanka integer,
    ammount integer,
    money integer,
    bikou character varying(100)
);


ALTER TABLE public.k_siire_d OWNER TO postgres;

--
-- Name: k_siire_m; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.k_siire_m (
    siire_cd integer NOT NULL,
    s_date date,
    p_date date,
    seikyuu_money integer,
    bikou character varying(100),
    g_cd integer,
    active boolean DEFAULT true,
    pay_date date,
    pay_money integer,
    pay_attr character varying(20),
    pay_bikou character varying(100)
);


ALTER TABLE public.k_siire_m OWNER TO postgres;

--
-- Name: k_siwake; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.k_siwake (
    siwake_cd smallint NOT NULL,
    siwake_name character varying(40)
);


ALTER TABLE public.k_siwake OWNER TO postgres;

--
-- Name: k_user_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.k_user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.k_user_seq OWNER TO postgres;

--
-- Name: kaikan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kaikan (
    k_pref character varying(8),
    k_siku character varying(20),
    k_tyou character varying(60),
    k_name character varying(80)
);


ALTER TABLE public.kaikan OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: kessai_method_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kessai_method_tb (
    method_id character varying(2) NOT NULL,
    kessai_name character varying(60),
    flg character varying(1)
);


ALTER TABLE public.kessai_method_tb OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: kigyo_report; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kigyo_report (
    num integer DEFAULT nextval(('kigyo_report_num_seq'::text)::regclass),
    c_name character varying(50),
    t_code character varying(12),
    start_date timestamp with time zone,
    last_date timestamp with time zone,
    bikou character varying(50)
);


ALTER TABLE public.kigyo_report OWNER TO postgres;

--
-- Name: kigyo_report_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kigyo_report_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kigyo_report_num_seq OWNER TO postgres;

--
-- Name: kms_sch_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kms_sch_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.kms_sch_seq OWNER TO postgres;

--
-- Name: kms_schedule; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kms_schedule (
    sch_id integer DEFAULT nextval(('kms_sch_seq'::text)::regclass) NOT NULL,
    sch_date date,
    sch_time character varying(2),
    sch_object text,
    member_id character varying(4),
    type character varying(2),
    reminder boolean DEFAULT false,
    fin_check boolean DEFAULT false,
    limit_date date,
    sch_time_2 character varying(4),
    sch_time_3 character varying(4),
    b_type character varying(2),
    e_date character varying(20),
    e_member_name character varying(42)
);


ALTER TABLE public.kms_schedule OWNER TO postgres;

--
-- Name: kmsupfile_filenum_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kmsupfile_filenum_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.kmsupfile_filenum_seq OWNER TO postgres;

--
-- Name: kojin_mail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.kojin_mail (
    k_cd integer DEFAULT nextval(('kojin_mail_seq'::text)::regclass),
    name character varying(60),
    mail character varying(50)
);


ALTER TABLE public.kojin_mail OWNER TO postgres;

--
-- Name: kojin_mail_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.kojin_mail_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.kojin_mail_seq OWNER TO postgres;

--
-- Name: label_opt_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.label_opt_order (
    ordercd integer NOT NULL,
    depocd smallint,
    disable character varying(2),
    ck_order boolean,
    ip_addr cidr,
    d_name character varying(40),
    ck_date timestamp with time zone,
    corporation character varying(60),
    branch character varying(60),
    "position" character varying(60),
    name character varying(60),
    purpose character varying(60),
    note text,
    opt_1 character varying(1),
    opt_2 character varying(1),
    opt_3 character varying(1),
    leadtime smallint,
    name2 character varying(60)
);


ALTER TABLE public.label_opt_order OWNER TO postgres;

--
-- Name: lcat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lcat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.lcat_id_seq OWNER TO postgres;

--
-- Name: leadtime; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.leadtime (
    leadtime smallint NOT NULL,
    limit_on1 smallint,
    limit_on2 smallint,
    limit_on3 smallint,
    days_on smallint,
    limit_next smallint,
    days_next smallint,
    type_on character varying(2),
    type_next character varying(5),
    remark text,
    permit boolean
);


ALTER TABLE public.leadtime OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: log_info; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_info (
    log_id integer NOT NULL,
    access_usercd character varying(120),
    access_type smallint,
    remote_ip_addr character varying(120),
    user_agent character varying(255),
    datetime timestamp without time zone NOT NULL,
    display_id integer NOT NULL,
    input_id character varying(120),
    input_pass character varying(120),
    errorcode smallint,
    site_type integer,
    file_no integer,
    file_name character varying(120),
    op_flg smallint
);


ALTER TABLE public.log_info OWNER TO postgres;

--
-- Name: log_info_log_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_info_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_info_log_id_seq OWNER TO postgres;

--
-- Name: log_info_log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_info_log_id_seq OWNED BY public.log_info.log_id;


SET default_with_oids = false;

--
-- Name: logi_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.logi_log (
    num integer DEFAULT nextval(('"logi_log_num_seq"'::text)::regclass) NOT NULL,
    login_date timestamp with time zone DEFAULT now(),
    depocd smallint NOT NULL,
    login_res character varying(2),
    login_ip cidr,
    d_name character varying(40)
);


ALTER TABLE public.logi_log OWNER TO postgres;

--
-- Name: logi_log_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.logi_log_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.logi_log_num_seq OWNER TO postgres;

--
-- Name: ls_acs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ls_acs (
    ls_id character varying(128),
    e_time timestamp with time zone
);


ALTER TABLE public.ls_acs OWNER TO postgres;

--
-- Name: ls_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ls_order (
    zeuscd integer,
    ls_id character varying(128),
    ordercd integer DEFAULT 0,
    status character varying(2) DEFAULT 'N'::character varying,
    send_date date
);


ALTER TABLE public.ls_order OWNER TO postgres;

--
-- Name: mail_queue; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mail_queue (
    id integer,
    create_time timestamp with time zone,
    time_to_send timestamp with time zone,
    sent_time timestamp with time zone,
    id_user integer,
    ip character varying(20),
    sender character varying(50),
    recipient text,
    headers text,
    body text,
    try_sent smallint DEFAULT 1,
    delete_after_send smallint
);


ALTER TABLE public.mail_queue OWNER TO postgres;

--
-- Name: mail_queue_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mail_queue_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mail_queue_seq OWNER TO postgres;

--
-- Name: mail_sub; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mail_sub (
    mail_sub_id integer DEFAULT nextval(('address_book_id_seq'::text)::regclass) NOT NULL,
    usercd integer NOT NULL,
    title character varying(36),
    sub_mail character varying(50) NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL,
    insert_at timestamp without time zone DEFAULT now() NOT NULL,
    update_at timestamp without time zone
);


ALTER TABLE public.mail_sub OWNER TO postgres;

--
-- Name: mail_sub_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mail_sub_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.mail_sub_id_seq OWNER TO postgres;

--
-- Name: manage_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.manage_tb (
    coid character varying(12),
    pass character varying(20),
    ag_list1 text,
    ag_list2 text,
    ag_list3 text,
    under_list text,
    pattern_type character varying(20),
    pattern_list text,
    reg_name character varying(60),
    e_code character varying(10),
    flg character varying(1),
    reg_date timestamp with time zone,
    bikou character varying(60),
    summary_flg character(1)
);


ALTER TABLE public.manage_tb OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: manage_tb_note; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.manage_tb_note (
    coid character varying(12) NOT NULL,
    note character varying(60)
);


ALTER TABLE public.manage_tb_note OWNER TO postgres;

--
-- Name: mcat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mcat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.mcat_id_seq OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: member_acs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.member_acs (
    acs_cd integer DEFAULT nextval(('member_acs_acs_cd_seq'::text)::regclass) NOT NULL,
    org_id character varying(12),
    membercd character varying(20),
    acs_date timestamp with time zone DEFAULT now(),
    acs_ip cidr,
    add1 character varying(8),
    add2 character varying(40)
);


ALTER TABLE public.member_acs OWNER TO postgres;

--
-- Name: member_acs_acs_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.member_acs_acs_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.member_acs_acs_cd_seq OWNER TO postgres;

--
-- Name: menu_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menu_tb (
    coid character varying(12) NOT NULL,
    ag1 character varying(12),
    ag2 character varying(12),
    ag3 character varying(12),
    class1_menu_list text,
    class2_menu_list text,
    class3_menu_list text,
    item_list text,
    note character varying(60),
    e_code character varying(10),
    flg character varying(1),
    reg_date timestamp without time zone
);


ALTER TABLE public.menu_tb OWNER TO postgres;

--
-- Name: message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.message (
    ordercd integer,
    zeuscd integer,
    usercd integer,
    c_title1 character varying(60),
    c_keisho1 character varying(12),
    c_title2 character varying(60),
    c_keisho2 character varying(12),
    c_title3 character varying(60),
    c_keisho3 character varying(12),
    c_mes1 character varying(64),
    c_mes2 character varying(64),
    c_mes3 character varying(64),
    c_mes4 character varying(64),
    c_mes5 character varying(64),
    c_mes6 character varying(64),
    c_mes7 character varying(64),
    c_mes8 character varying(64),
    c_mes9 character varying(64),
    c_mes10 character varying(64),
    c_from1 character varying(60),
    c_from2 character varying(60),
    c_from3 character varying(60),
    fimgcd character varying(4),
    c_logo character varying(2),
    direction character varying(1),
    c_title4 character varying(60) DEFAULT ''::character varying,
    c_keisho4 character varying(12),
    c_from4 character varying(60) DEFAULT ''::character varying
);


ALTER TABLE public.message OWNER TO postgres;

--
-- Name: message_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.message_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.message_group_id_seq OWNER TO postgres;

--
-- Name: met_sso_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.met_sso_order (
    ordercd integer NOT NULL,
    pr_1 character varying(60),
    pr_2 character varying(60),
    pr_3 character varying(60)
);


ALTER TABLE public.met_sso_order OWNER TO postgres;

--
-- Name: mew_in; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mew_in (
    in_cd integer DEFAULT nextval(('"mew_in_cd_seq"'::text)::regclass) NOT NULL,
    in_date date,
    in_name character varying(100),
    in_money integer,
    in_bank character varying(40),
    in_bikou character varying(100),
    in_check boolean DEFAULT false
);


ALTER TABLE public.mew_in OWNER TO postgres;

--
-- Name: mew_in_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mew_in_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mew_in_cd_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: mew_pay; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mew_pay (
    kt_cd character varying(10),
    kt_name character varying(100),
    s_ym character varying(10),
    p_name character varying(60),
    p_money integer,
    p_date date,
    p_bikou character varying(100),
    in_cd integer
);


ALTER TABLE public.mew_pay OWNER TO postgres;

--
-- Name: no_send_mail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.no_send_mail (
    usercd integer,
    u_mail character varying(50),
    stop_date timestamp without time zone,
    tantou character varying(50),
    bikou text
);


ALTER TABLE public.no_send_mail OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: notice_site_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notice_site_tb (
    set_type character varying(2),
    site_name character varying(255),
    save_dir character varying(255),
    flg character varying(1)
);


ALTER TABLE public.notice_site_tb OWNER TO postgres;

--
-- Name: notice_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notice_tb (
    notice_id integer DEFAULT nextval(('notice_tb_seq'::text)::regclass) NOT NULL,
    memo text,
    link_str text,
    file_name character varying(60),
    set_type character varying(2),
    title character varying(60),
    txt text,
    bikou character varying(60),
    e_code character varying(10),
    flg character varying(1),
    reg_date timestamp with time zone
);


ALTER TABLE public.notice_tb OWNER TO postgres;

--
-- Name: notice_tb_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notice_tb_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.notice_tb_seq OWNER TO postgres;

--
-- Name: ntt_bun; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ntt_bun (
    nbun_cd smallint,
    cate_1 character varying(1),
    cate_2 character varying(2),
    sentence character varying(100),
    kaigyou character varying(20)
);


ALTER TABLE public.ntt_bun OWNER TO postgres;

--
-- Name: ntt_flg_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ntt_flg_tb (
    ordercd integer NOT NULL,
    pdf_name character varying(255),
    fax_flg1 character(1),
    fax_flg2 character(1),
    m_flg character(1),
    flg1 character varying(255),
    flg2 character varying(255),
    flg3 character varying(255),
    flg4 character varying(255),
    flg5 character varying(255),
    f_date timestamp with time zone
);


ALTER TABLE public.ntt_flg_tb OWNER TO postgres;

--
-- Name: ntt_tsuban_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ntt_tsuban_tb (
    id integer DEFAULT nextval(('tsuban_seq'::text)::regclass) NOT NULL,
    flg1 character(1),
    flg2 character(1),
    flg3 character(1)
);


ALTER TABLE public.ntt_tsuban_tb OWNER TO postgres;

--
-- Name: odat_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.odat_test (
    ordercd integer,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    m_coname character varying(80),
    m_branch character varying(80),
    m_section character varying(80),
    m_yaku character varying(60),
    m_name character varying(60),
    m_post character varying(7),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_tel character varying(15),
    m_fax character varying(15),
    m_mail character varying(50),
    m_mail_sub1 character varying(50),
    m_mail_sub2 character varying(50),
    a_keisho character varying(60),
    a_name2 character varying(60),
    a_keisho2 character varying(60)
);


ALTER TABLE public.odat_test OWNER TO postgres;

--
-- Name: oem_buncd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_buncd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.oem_buncd_seq OWNER TO postgres;

--
-- Name: oem_custom_bun; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oem_custom_bun (
    buncd integer DEFAULT nextval(('oem_buncd_seq'::text)::regclass) NOT NULL,
    cate_cd character varying(2),
    oem_login_no integer NOT NULL,
    title character varying(40),
    text1 character varying(60),
    text2 character varying(60),
    text3 character varying(60),
    text4 character varying(60),
    text5 character varying(60),
    text6 character varying(60),
    text7 character varying(60),
    text8 character varying(60),
    text9 character varying(60),
    text10 character varying(60)
);


ALTER TABLE public.oem_custom_bun OWNER TO postgres;

--
-- Name: oem_fromcd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_fromcd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.oem_fromcd_seq OWNER TO postgres;

--
-- Name: oem_fromname; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oem_fromname (
    fromcd integer DEFAULT nextval(('oem_fromcd_seq'::text)::regclass) NOT NULL,
    oem_login_no integer NOT NULL,
    from1 character varying(60),
    from2 character varying(60),
    from3 character varying(60)
);


ALTER TABLE public.oem_fromname OWNER TO postgres;

--
-- Name: oem_login_no_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_login_no_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.oem_login_no_seq OWNER TO postgres;

--
-- Name: oem_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oem_order (
    ordercd integer NOT NULL,
    oem_login_no integer NOT NULL,
    inquiry_no character varying(12),
    start_branch_cd character varying(6),
    end_branch_cd character varying(6),
    cancel_date timestamp without time zone,
    change_date timestamp without time zone,
    order_send timestamp without time zone,
    arrival_send timestamp without time zone,
    fixed_send timestamp without time zone,
    cancel_change_send timestamp without time zone DEFAULT now(),
    guest_order_flg boolean DEFAULT false NOT NULL,
    cut_off_day character varying(2),
    start_branch_nm character varying(20),
    end_branch_nm character varying(20)
);


ALTER TABLE public.oem_order OWNER TO postgres;

--
-- Name: oem_order_inquiry_no_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_order_inquiry_no_seq
    START WITH 0
    INCREMENT BY 1
    MINVALUE 0
    MAXVALUE 999999
    CACHE 1
    CYCLE;


ALTER TABLE public.oem_order_inquiry_no_seq OWNER TO postgres;

--
-- Name: oem_order_non_letter_inquiry_no_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_order_non_letter_inquiry_no_seq
    START WITH 1000000
    INCREMENT BY 1
    MINVALUE 1000000
    MAXVALUE 1999999
    CACHE 1
    CYCLE;


ALTER TABLE public.oem_order_non_letter_inquiry_no_seq OWNER TO postgres;

--
-- Name: oem_quest; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oem_quest (
    q_cd integer DEFAULT nextval(('oem_quest_seq'::text)::regclass) NOT NULL,
    q_date timestamp without time zone,
    q_oem_login_no integer,
    q_mail character varying(50),
    q_name character varying(60),
    q_cname character varying(60),
    q_naiyou text,
    r_tantou character varying(20),
    r_date timestamp without time zone,
    r_naiyou text,
    q_tel character varying(15),
    q_inquiry_no character varying(12),
    q_cust_cd character varying(12),
    q_coid character varying(12),
    q_page character varying(2),
    q_name_furi character varying(60),
    q_section character varying(60),
    q_press_name character varying(120)
);


ALTER TABLE public.oem_quest OWNER TO postgres;

--
-- Name: oem_quest_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oem_quest_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.oem_quest_seq OWNER TO postgres;

--
-- Name: oem_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oem_user (
    oem_login_no integer DEFAULT nextval(('oem_login_no_seq'::text)::regclass) NOT NULL,
    oem_login_name character varying(60),
    oem_cd character varying(10) NOT NULL,
    user_no character varying(15),
    cust_cd character varying(12)
);


ALTER TABLE public.oem_user OWNER TO postgres;

--
-- Name: omas_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.omas_test (
    ordercd integer,
    ordernum smallint,
    usercd integer,
    coid character varying(12),
    acs_cd integer,
    item_type character varying(2),
    money1 integer,
    money2 integer,
    ag_1 character varying(12),
    ag_fee1 integer,
    ag_2 character varying(12),
    ag_fee2 integer,
    ag_3 character varying(12),
    ag_fee3 integer,
    pay character varying(2),
    o_type character varying(2),
    o_bikou character varying(60),
    s_cd integer,
    o_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(6),
    permit boolean,
    del_cd integer,
    del_num smallint,
    a_time character varying(10),
    c_flg boolean,
    c_use smallint,
    c_other character varying(60)
);


ALTER TABLE public.omas_test OWNER TO postgres;

--
-- Name: omron; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.omron (
    coid character varying(13) NOT NULL,
    scc character varying(5),
    sa character varying(5),
    check_mail boolean DEFAULT false
);


ALTER TABLE public.omron OWNER TO postgres;

--
-- Name: omron_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.omron_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.omron_id_seq OWNER TO postgres;

--
-- Name: opt_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.opt_order (
    ordercd integer NOT NULL,
    ordernum smallint NOT NULL,
    item_cd character varying(10),
    item_name character varying(30),
    opt_1 character varying(60),
    opt_2 character varying(60),
    opt_3 character varying(60),
    opt_4 character varying(60),
    opt_5 character varying(60),
    bikou text,
    ck_date timestamp with time zone,
    jfn_1 timestamp with time zone,
    jfn_2 character varying(40),
    jfn_3 character varying(60),
    jfn_4 character varying(60),
    jfn_5 character varying(60),
    jfn_6 character varying(60),
    jfn_7 character varying(60),
    opt_6 character varying(60),
    opt_7 character varying(60)
);


ALTER TABLE public.opt_order OWNER TO postgres;

--
-- Name: opt_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.opt_test (
    ordercd integer,
    ordernum smallint,
    item_cd character varying(10),
    item_name character varying(30),
    opt_1 character varying(60),
    opt_2 character varying(60),
    opt_3 character varying(60),
    opt_4 character varying(60),
    opt_5 character varying(60),
    bikou text,
    ck_date timestamp with time zone,
    jfn_1 timestamp with time zone,
    jfn_2 character varying(40),
    jfn_3 character varying(60),
    jfn_4 character varying(60),
    jfn_5 character varying(60),
    jfn_6 character varying(60),
    jfn_7 character varying(60),
    opt_6 character varying(60),
    opt_7 character varying(60)
);


ALTER TABLE public.opt_test OWNER TO postgres;

--
-- Name: order_barcode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_barcode (
    ordercd integer NOT NULL,
    depocd integer NOT NULL,
    quest_cd numeric(12,0) NOT NULL,
    quest_cscd character varying(13) NOT NULL,
    flg_prt character(1) DEFAULT '0'::bpchar NOT NULL,
    flg_out character(1) DEFAULT '0'::bpchar NOT NULL,
    flg_fin character(1) DEFAULT '0'::bpchar NOT NULL,
    flg_bak character(1) DEFAULT '0'::bpchar NOT NULL,
    status character varying(2) DEFAULT '0'::character varying NOT NULL,
    tantou_prt character varying(60),
    tantou_out character varying(60),
    tantou_fin character varying(60),
    tantou_bak character varying(60),
    date_prt timestamp without time zone,
    date_out timestamp without time zone,
    date_fin timestamp without time zone,
    date_bak timestamp without time zone,
    remark text,
    update_at timestamp without time zone,
    sub_barcode_id integer
);


ALTER TABLE public.order_barcode OWNER TO postgres;

--
-- Name: order_barcode_bak; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_barcode_bak (
    bak_id integer DEFAULT nextval(('order_barcode_bak_id_seq'::text)::regclass) NOT NULL,
    ordercd integer NOT NULL,
    quest_cscd character varying(13) NOT NULL,
    tantou_bak character varying(60),
    date_bak timestamp without time zone,
    detail character varying(2),
    reason text,
    remark text,
    tantou_out character varying(60),
    date_out timestamp without time zone,
    permit_bak boolean DEFAULT true NOT NULL,
    permit_out boolean DEFAULT false NOT NULL
);


ALTER TABLE public.order_barcode_bak OWNER TO postgres;

--
-- Name: order_barcode_bak_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_barcode_bak_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.order_barcode_bak_id_seq OWNER TO postgres;

--
-- Name: order_barcode_fix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_barcode_fix (
    depocd integer NOT NULL,
    year smallint NOT NULL,
    mon smallint NOT NULL,
    type smallint NOT NULL,
    tantou character varying(60) NOT NULL,
    fix_01 character varying(4),
    fix_02 character varying(4),
    fix_03 character varying(4),
    fix_04 character varying(4),
    fix_05 character varying(4),
    fix_06 character varying(4),
    fix_07 character varying(4),
    fix_08 character varying(4),
    fix_09 character varying(4),
    fix_10 character varying(4),
    fix_11 character varying(4),
    fix_12 character varying(4),
    fix_13 character varying(4),
    fix_14 character varying(4),
    fix_15 character varying(4),
    fix_16 character varying(4),
    fix_17 character varying(4),
    fix_18 character varying(4),
    fix_19 character varying(4),
    fix_20 character varying(4),
    fix_21 character varying(4),
    fix_22 character varying(4),
    fix_23 character varying(4),
    fix_24 character varying(4),
    fix_25 character varying(4),
    fix_26 character varying(4),
    fix_27 character varying(4),
    fix_28 character varying(4),
    fix_29 character varying(4),
    fix_30 character varying(4),
    fix_31 character varying(4),
    fix_at timestamp without time zone DEFAULT now() NOT NULL,
    ck_pdf boolean DEFAULT false NOT NULL,
    ck_date timestamp without time zone
);


ALTER TABLE public.order_barcode_fix OWNER TO postgres;

--
-- Name: order_barcode_fix_mng; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_barcode_fix_mng (
    depocd integer NOT NULL,
    year smallint NOT NULL,
    mon smallint NOT NULL,
    depocd_act integer NOT NULL,
    tantou character varying(60),
    fix_01 character varying(6),
    fix_02 character varying(6),
    fix_03 character varying(6),
    fix_at timestamp without time zone DEFAULT now(),
    ck_pdf boolean,
    ck_date timestamp without time zone
);


ALTER TABLE public.order_barcode_fix_mng OWNER TO postgres;

--
-- Name: order_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_data (
    ordercd integer,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    m_coname character varying(80),
    m_branch character varying(80),
    m_section character varying(80),
    m_yaku character varying(60),
    m_name character varying(60),
    m_post character varying(7),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_tel character varying(15),
    m_fax character varying(15),
    m_mail character varying(50),
    m_mail_sub1 character varying(50),
    m_mail_sub2 character varying(50),
    a_keisho character varying(60),
    a_name2 character varying(60) DEFAULT ''::character varying,
    a_keisho2 character varying(60)
);


ALTER TABLE public.order_data OWNER TO postgres;

--
-- Name: order_data_old; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_data_old (
    ordercd integer,
    a_post character varying(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_name character varying(60),
    a_tel character varying(15),
    cerehall character varying(100),
    m_coname character varying(80),
    m_branch character varying(80),
    m_section character varying(80),
    m_yaku character varying(60),
    m_name character varying(60),
    m_post character varying(7),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_tel character varying(15),
    m_fax character varying(15),
    m_mail character varying(50),
    m_mail_sub1 character varying(50),
    m_mail_sub2 character varying(50),
    a_keisho character varying(60),
    a_name2 character varying(60),
    a_keisho2 character varying(60)
);


ALTER TABLE public.order_data_old OWNER TO postgres;

--
-- Name: order_etc_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_etc_data (
    ordercd integer NOT NULL,
    etc_info_1 character varying(100),
    etc_info_2 character varying(100),
    etc_info_3 character varying(100),
    etc_info_4 character varying(100),
    etc_info_5 character varying(100),
    etc_info_6 character varying(100),
    etc_info_7 character varying(100),
    etc_info_8 character varying(100),
    etc_info_9 character varying(100),
    etc_info_10 character varying(100),
    v_order_pass character varying
);


ALTER TABLE public.order_etc_data OWNER TO postgres;

--
-- Name: order_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_master (
    ordercd integer,
    ordernum smallint,
    usercd integer,
    coid character varying(12),
    acs_cd integer,
    item_type character varying(2),
    money1 integer,
    money2 integer,
    ag_1 character varying(12),
    ag_fee1 integer,
    ag_2 character varying(12),
    ag_fee2 integer,
    ag_3 character varying(12),
    ag_fee3 integer,
    pay character varying(2),
    o_type character varying(2),
    o_bikou character varying(60),
    s_cd integer,
    o_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(6),
    permit boolean,
    del_cd integer,
    del_num smallint,
    a_time character varying(10),
    c_flg boolean,
    c_use smallint,
    c_other character varying(60)
);


ALTER TABLE public.order_master OWNER TO postgres;

--
-- Name: order_master_old; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_master_old (
    ordercd integer,
    ordernum smallint,
    usercd integer,
    coid character varying(12),
    acs_cd integer,
    item_type character varying(2),
    money1 integer,
    money2 integer,
    ag_1 character varying(12),
    ag_fee1 integer,
    ag_2 character varying(12),
    ag_fee2 integer,
    ag_3 character varying(12),
    ag_fee3 integer,
    pay character varying(2),
    o_type character varying(2),
    o_bikou character varying(60),
    s_cd integer,
    o_date timestamp with time zone,
    a_date date,
    c_date date,
    c_time character varying(6),
    permit boolean,
    del_cd integer,
    del_num smallint,
    a_time character varying(10),
    c_flg boolean,
    c_use smallint,
    c_other character varying(60)
);


ALTER TABLE public.order_master_old OWNER TO postgres;

--
-- Name: order_template_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_template_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.order_template_seq OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: order_template; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_template (
    tempcd integer DEFAULT nextval('public.order_template_seq'::regclass) NOT NULL,
    usercd integer NOT NULL,
    title character varying(40) NOT NULL,
    item_cd character varying(10),
    daisi character varying(1),
    fonts character varying(1),
    text1 character varying(60),
    text2 character varying(60),
    text3 character varying(60),
    text4 character varying(60),
    text5 character varying(60),
    text6 character varying(60),
    text7 character varying(60),
    text8 character varying(60),
    text9 character varying(60),
    text10 character varying(60),
    from1 character varying(60),
    from2 character varying(60),
    from3 character varying(60),
    fimgcd character varying(4),
    enable boolean DEFAULT true NOT NULL,
    insert_at timestamp with time zone DEFAULT now(),
    update_at timestamp with time zone,
    last_used timestamp with time zone,
    from4 character varying(60),
    regist_type character varying(1) DEFAULT '1'::character varying,
    item_method character varying(1) DEFAULT '1'::character varying,
    sp boolean,
    ntt_reserve boolean,
    a_post character(7),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(200),
    a_addr character varying(100),
    a_build character varying(100),
    a_cerehall character varying(100),
    a_tel character varying(15),
    a_name1 character varying(60),
    a_keishou1 character varying(60),
    a_name2 character varying(60),
    a_keishou2 character varying(60),
    d_name character varying(60),
    c_use smallint,
    c_other character varying(60),
    c_flg boolean,
    c_year smallint,
    c_mon smallint,
    c_day smallint,
    c_time character varying(6),
    a_year smallint,
    a_mon smallint,
    a_day smallint,
    a_time character varying(10),
    direction character varying(1),
    c_title1 character varying(60),
    c_title2 character varying(60),
    c_title3 character varying(60),
    c_title4 character varying(60),
    c_keisho1 character varying(12),
    c_keisho2 character varying(12),
    c_keisho3 character varying(12),
    c_keisho4 character varying(12),
    prize boolean,
    m_post character varying(7),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_tel character varying(15),
    m_coname character varying(80),
    m_branch character varying(80),
    m_section character varying(80),
    m_yaku character varying(60),
    m_name character varying(60),
    m_fax character varying(15),
    m_tel_emg character varying(15),
    m_mail character varying(50),
    m_mail_sub1 character varying(50),
    m_mail_sub2 character varying(50),
    o_bikou character varying(60),
    o_bikou1 character varying(60),
    o_bikou2 character varying(60),
    tick text
);


ALTER TABLE public.order_template OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: ordercd_barcode_link; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ordercd_barcode_link (
    ordercd integer NOT NULL,
    sub_quest_cscd character varying(15) NOT NULL,
    sub_company_cd integer
);


ALTER TABLE public.ordercd_barcode_link OWNER TO postgres;

--
-- Name: ordercd_test_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ordercd_test_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ordercd_test_seq OWNER TO postgres;

--
-- Name: orderid_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orderid_tb (
    orderid character(27),
    sendid integer,
    accessid character(32),
    accesspass character(32),
    edate character(8),
    etime character(8)
);


ALTER TABLE public.orderid_tb OWNER TO postgres;

--
-- Name: org_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.org_master (
    org_id character varying(12) NOT NULL,
    org_name character varying(60),
    addr1 smallint,
    addr2 character varying(100),
    o_tel character varying(15),
    o_mail character varying(50),
    u_tanka smallint,
    u_tanka2 smallint,
    pay_way character varying(1),
    card_m smallint,
    opt_m smallint,
    gcat_m smallint,
    restriction character varying(50),
    o_pass character varying(12),
    u_tanka3 smallint,
    tiger_m smallint
);


ALTER TABLE public.org_master OWNER TO postgres;

--
-- Name: otemp_ordercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.otemp_ordercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.otemp_ordercd_seq OWNER TO postgres;

--
-- Name: past_company_general_account; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.past_company_general_account (
    coid character varying(13) NOT NULL,
    bank_account_id integer NOT NULL
);


ALTER TABLE public.past_company_general_account OWNER TO postgres;

--
-- Name: past_company_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.past_company_opt (
    coid character varying(13) NOT NULL,
    bill_pay_type smallint,
    bill_pay_day character varying(2),
    account_num integer
);


ALTER TABLE public.past_company_opt OWNER TO postgres;

--
-- Name: price_plan_company; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.price_plan_company (
    coid character varying(12) NOT NULL,
    price_plan_master_id integer NOT NULL,
    remark text,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.price_plan_company OWNER TO postgres;

--
-- Name: price_plan_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.price_plan_item (
    price_plan_master_id integer NOT NULL,
    item_cd character varying(10) NOT NULL,
    price numeric(10,0),
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.price_plan_item OWNER TO postgres;

--
-- Name: price_plan_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.price_plan_master (
    price_plan_master_id integer DEFAULT nextval(('price_plan_master_id_seq'::text)::regclass) NOT NULL,
    scat_cd smallint NOT NULL,
    price_plan_id smallint NOT NULL,
    price_plan_name character varying(50) NOT NULL,
    dsp_turn smallint NOT NULL,
    remark text,
    default_flg boolean DEFAULT false NOT NULL,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.price_plan_master OWNER TO postgres;

--
-- Name: price_plan_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_plan_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.price_plan_master_id_seq OWNER TO postgres;

--
-- Name: proper_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proper_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proper_stock_id_seq OWNER TO postgres;

--
-- Name: q_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.q_history (
    q_cd integer DEFAULT nextval(('"q_history_q_cd_seq"'::text)::regclass) NOT NULL,
    ordercd integer NOT NULL,
    q_date timestamp with time zone DEFAULT now(),
    tantou character varying(20),
    q_name character varying(40),
    title character varying(40),
    detail text,
    q_name2 character varying(40),
    title2 character varying(40),
    detail2 text,
    channel_cd1 character varying(2) DEFAULT ''::character varying NOT NULL,
    channel_cd2 character varying(2) DEFAULT ''::character varying NOT NULL,
    q_lcat_cd character varying(5) DEFAULT ''::character varying NOT NULL,
    q_mcat_cd character varying(5) DEFAULT ''::character varying NOT NULL,
    q_scat_cd character varying(6) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.q_history OWNER TO postgres;

--
-- Name: q_history_lcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.q_history_lcat (
    q_lcat_id integer DEFAULT nextval(('q_lcat_id_seq'::text)::regclass) NOT NULL,
    q_lcat_cd character varying(5) NOT NULL,
    q_lcat_nm character varying(30) NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL,
    item_dsp_turn smallint
);


ALTER TABLE public.q_history_lcat OWNER TO postgres;

--
-- Name: q_history_mcat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.q_history_mcat (
    q_mcat_id integer DEFAULT nextval(('q_mcat_id_seq'::text)::regclass) NOT NULL,
    q_lcat_cd character varying(5) NOT NULL,
    q_mcat_cd character varying(5) NOT NULL,
    q_mcat_nm character varying(30) NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL,
    item_dsp_turn smallint
);


ALTER TABLE public.q_history_mcat OWNER TO postgres;

--
-- Name: q_history_q_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.q_history_q_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.q_history_q_cd_seq OWNER TO postgres;

--
-- Name: q_history_scat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.q_history_scat (
    q_scat_id integer DEFAULT nextval(('q_scat_id_seq'::text)::regclass) NOT NULL,
    q_lcat_cd character varying(5) NOT NULL,
    q_mcat_cd character varying(5) NOT NULL,
    q_scat_cd character varying(6) NOT NULL,
    q_scat_nm character varying(30) NOT NULL,
    remark text,
    permit boolean DEFAULT true NOT NULL,
    item_dsp_turn smallint
);


ALTER TABLE public.q_history_scat OWNER TO postgres;

--
-- Name: q_lcat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.q_lcat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.q_lcat_id_seq OWNER TO postgres;

--
-- Name: q_mcat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.q_mcat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.q_mcat_id_seq OWNER TO postgres;

--
-- Name: q_scat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.q_scat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.q_scat_id_seq OWNER TO postgres;

--
-- Name: quest; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.quest (
    q_cd integer NOT NULL,
    q_date timestamp with time zone,
    q_usercd bigint,
    q_mail character varying(50),
    q_name character varying(60),
    q_cname character varying(60),
    q_naiyou text,
    r_tantou character varying(20),
    r_date timestamp with time zone,
    r_naiyou text,
    q_tel character varying(15),
    q_ordercd integer,
    q_coid character varying(12),
    q_page character varying(2),
    q_name_furi character varying(60),
    q_section character varying(60),
    q_press_name character varying(120)
);


ALTER TABLE public.quest OWNER TO postgres;

--
-- Name: quest_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.quest_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.quest_id_seq OWNER TO postgres;

--
-- Name: quest_old; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.quest_old (
    q_cd integer,
    q_date timestamp with time zone,
    q_usercd bigint,
    q_mail character varying(50),
    q_name character varying(60),
    q_cname character varying(60),
    q_naiyou text,
    r_tantou character varying(20),
    r_date timestamp with time zone,
    r_naiyou text
);


ALTER TABLE public.quest_old OWNER TO postgres;

--
-- Name: queue_test_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.queue_test_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.queue_test_seq OWNER TO postgres;

--
-- Name: r_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.r_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.r_cd_seq OWNER TO postgres;

--
-- Name: report_composition_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.report_composition_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.report_composition_detail_id_seq OWNER TO postgres;

--
-- Name: report_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.report_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.report_detail_id_seq OWNER TO postgres;

--
-- Name: report_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.report_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.report_id_seq OWNER TO postgres;

--
-- Name: review; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.review (
    cam_num integer NOT NULL,
    item_cd character varying(10),
    dsp_turn integer,
    review text NOT NULL,
    enable boolean DEFAULT false NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.review OWNER TO postgres;

--
-- Name: rireki; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rireki (
    r_cd integer DEFAULT nextval(('r_cd_seq'::text)::regclass) NOT NULL,
    r_kanri character varying(5) NOT NULL,
    r_target character varying(20),
    r_do character varying(10),
    r_detail_before text,
    r_detail_after text,
    r_irai character varying(30),
    r_tantou character varying(30),
    r_date timestamp with time zone DEFAULT ('now'::text)::timestamp without time zone,
    r_reason text,
    r_bikou character varying(500)
);


ALTER TABLE public.rireki OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: s_alert; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_alert (
    alert_id integer DEFAULT nextval('public.alert_id_seq'::regclass) NOT NULL,
    depocd integer NOT NULL,
    item_id integer NOT NULL,
    alert_type smallint NOT NULL
);


ALTER TABLE public.s_alert OWNER TO postgres;

--
-- Name: s_all_correspondence; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_all_correspondence (
    depocd integer NOT NULL
);


ALTER TABLE public.s_all_correspondence OWNER TO postgres;

--
-- Name: s_beginning_month_composition_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_beginning_month_composition_stock (
    object_years integer NOT NULL,
    item_composition_master_id integer NOT NULL,
    depocd integer NOT NULL,
    theory_stock integer NOT NULL
);


ALTER TABLE public.s_beginning_month_composition_stock OWNER TO postgres;

--
-- Name: s_beginning_month_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_beginning_month_stock (
    object_years integer NOT NULL,
    item_id integer NOT NULL,
    depocd integer NOT NULL,
    theory_stock integer NOT NULL
);


ALTER TABLE public.s_beginning_month_stock OWNER TO postgres;

--
-- Name: s_change_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_change_history (
    change_id integer DEFAULT nextval('public.change_id_seq'::regclass) NOT NULL,
    change text NOT NULL,
    change_reason text,
    change_screen character varying(100),
    change_name character varying(100) NOT NULL,
    change_date timestamp without time zone NOT NULL
);


ALTER TABLE public.s_change_history OWNER TO postgres;

--
-- Name: s_dead_stock_composition_results; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_dead_stock_composition_results (
    dead_stock_results_id integer DEFAULT nextval('public.dead_stock_composition_results_id_seq'::regclass) NOT NULL,
    depocd integer NOT NULL,
    item_composition_master_id integer NOT NULL,
    dead_stock smallint NOT NULL,
    inspecting_num smallint NOT NULL,
    return_at date NOT NULL
);


ALTER TABLE public.s_dead_stock_composition_results OWNER TO postgres;

--
-- Name: s_dead_stock_results; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_dead_stock_results (
    dead_stock_results_id integer DEFAULT nextval('public.dead_stock_results_id_seq'::regclass) NOT NULL,
    depocd integer NOT NULL,
    item_id integer NOT NULL,
    dead_stock smallint NOT NULL,
    inspecting_num smallint NOT NULL,
    return_at date NOT NULL
);


ALTER TABLE public.s_dead_stock_results OWNER TO postgres;

--
-- Name: s_delivery_results; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_delivery_results (
    delivery_results_id integer DEFAULT nextval('public.delivery_results_id_seq'::regclass) NOT NULL,
    stock_id integer NOT NULL,
    delivery_results_years integer NOT NULL,
    delivery_results_num integer
);


ALTER TABLE public.s_delivery_results OWNER TO postgres;

--
-- Name: s_depo_change_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_depo_change_history (
    id integer DEFAULT nextval('public.depo_change_history_id_seq'::regclass) NOT NULL,
    zipcode integer NOT NULL,
    from_depo integer NOT NULL,
    to_depo integer NOT NULL,
    parent_id integer
);


ALTER TABLE public.s_depo_change_history OWNER TO postgres;

--
-- Name: s_depo_transport_object; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_depo_transport_object (
    depocd integer NOT NULL,
    object_depocd integer NOT NULL
);


ALTER TABLE public.s_depo_transport_object OWNER TO postgres;

--
-- Name: s_depo_transports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_depo_transports (
    depo_transports_id integer DEFAULT nextval('public.depo_transports_id_seq'::regclass) NOT NULL,
    shipping_no character varying(15) NOT NULL,
    shipment_origin_depocd integer NOT NULL,
    shipment_destination_depocd integer NOT NULL,
    shipment_request_date date,
    reports text,
    address character varying(255),
    tel character varying(15),
    fax character varying(15),
    delivered_desired_date date,
    shipment_date date,
    arrival_date date,
    person_in_charge character varying(50),
    shipment_origin_status character varying(1),
    shipment_destination_status character varying(1),
    shipment_ls_status character varying(1),
    regist_name character varying(50),
    regist_at timestamp without time zone NOT NULL
);


ALTER TABLE public.s_depo_transports OWNER TO postgres;

--
-- Name: transports_composition_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.transports_composition_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transports_composition_detail_id_seq OWNER TO postgres;

--
-- Name: s_depo_transports_composition_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_depo_transports_composition_detail (
    transports_composition_detail_id integer DEFAULT nextval('public.transports_composition_detail_id_seq'::regclass) NOT NULL,
    depo_transports_id integer NOT NULL,
    item_composition_master_id integer NOT NULL,
    shipment_num smallint NOT NULL,
    arrival_num smallint NOT NULL,
    remarks character varying(100),
    remarks2 text,
    remarks3 text
);


ALTER TABLE public.s_depo_transports_composition_detail OWNER TO postgres;

--
-- Name: s_depo_transports_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_depo_transports_detail (
    depo_transports_detail_id integer DEFAULT nextval('public.depo_transports_detail_id_seq'::regclass) NOT NULL,
    depo_transports_id integer NOT NULL,
    item_id integer NOT NULL,
    proper_stock_num smallint NOT NULL,
    shipment_num smallint NOT NULL,
    arrival_num smallint NOT NULL,
    remarks text,
    remarks2 text,
    remarks3 text
);


ALTER TABLE public.s_depo_transports_detail OWNER TO postgres;

--
-- Name: s_district; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_district (
    district_id integer NOT NULL,
    district_name character varying(20) NOT NULL
);


ALTER TABLE public.s_district OWNER TO postgres;

--
-- Name: s_item_composition; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_item_composition (
    item_id integer NOT NULL,
    item_composition_master_id integer NOT NULL
);


ALTER TABLE public.s_item_composition OWNER TO postgres;

--
-- Name: s_item_composition_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_item_composition_master (
    item_composition_master_id integer DEFAULT nextval('public.item_composition_master_id_seq'::regclass) NOT NULL,
    item_composition_cd character varying(10) NOT NULL,
    item_composition_name character varying(50),
    item_composition_type integer DEFAULT 0 NOT NULL,
    item_composition_num integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.s_item_composition_master OWNER TO postgres;

--
-- Name: s_item_composition_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_item_composition_stock (
    item_composition_stock_id integer DEFAULT nextval('public.item_composition_stock_id_seq'::regclass) NOT NULL,
    item_composition_master_id integer NOT NULL,
    depocd smallint NOT NULL,
    theory_stock integer NOT NULL,
    dead_stock integer NOT NULL,
    one_day_delivery integer,
    two_day_delivery integer,
    one_week_delivery integer,
    one_month_delivery integer
);


ALTER TABLE public.s_item_composition_stock OWNER TO postgres;

--
-- Name: s_message_group_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_message_group_detail (
    message_group_id integer NOT NULL,
    depocd integer NOT NULL
);


ALTER TABLE public.s_message_group_detail OWNER TO postgres;

--
-- Name: s_message_group_mst; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_message_group_mst (
    message_group_id integer DEFAULT nextval('public.message_group_id_seq'::regclass) NOT NULL,
    message_group_name character varying(100)
);


ALTER TABLE public.s_message_group_mst OWNER TO postgres;

--
-- Name: s_monthly_report; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_monthly_report (
    report_id integer DEFAULT nextval('public.report_id_seq'::regclass) NOT NULL,
    results_years integer NOT NULL,
    depocd integer NOT NULL,
    regist_date date NOT NULL,
    regist_name character varying(100) NOT NULL,
    fixed_date date,
    fixed smallint NOT NULL,
    reports text
);


ALTER TABLE public.s_monthly_report OWNER TO postgres;

--
-- Name: s_monthly_report_composition_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_monthly_report_composition_detail (
    report_composition_detail_id integer DEFAULT nextval('public.report_composition_detail_id_seq'::regclass) NOT NULL,
    report_id integer NOT NULL,
    item_composition_master_id integer NOT NULL,
    theory_stock_num integer NOT NULL,
    theory_stock_total integer NOT NULL,
    real_stock_num integer NOT NULL,
    good_stock_num integer NOT NULL,
    dead_stock_num integer NOT NULL,
    reason text,
    reason_type smallint
);


ALTER TABLE public.s_monthly_report_composition_detail OWNER TO postgres;

--
-- Name: s_monthly_report_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_monthly_report_detail (
    report_detail_id integer DEFAULT nextval('public.report_detail_id_seq'::regclass) NOT NULL,
    report_id integer NOT NULL,
    item_id integer NOT NULL,
    theory_stock_num integer NOT NULL,
    theory_stock_total integer NOT NULL,
    real_stock_num integer NOT NULL,
    good_stock_num integer NOT NULL,
    dead_stock_num integer NOT NULL,
    reason text,
    reason_type smallint
);


ALTER TABLE public.s_monthly_report_detail OWNER TO postgres;

--
-- Name: s_pref; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_pref (
    pref_id integer NOT NULL,
    pref_name character varying(10) NOT NULL,
    district_id integer NOT NULL
);


ALTER TABLE public.s_pref OWNER TO postgres;

--
-- Name: s_proper_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_proper_stock (
    proper_stock_id integer DEFAULT nextval('public.proper_stock_id_seq'::regclass) NOT NULL,
    stock_id integer NOT NULL,
    object_years integer NOT NULL,
    proper_stock smallint NOT NULL,
    warning_num smallint NOT NULL,
    attention_num smallint NOT NULL,
    season_factor numeric(3,1) NOT NULL
);


ALTER TABLE public.s_proper_stock OWNER TO postgres;

--
-- Name: shipment_composition_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipment_composition_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipment_composition_stock_id_seq OWNER TO postgres;

--
-- Name: s_shipment_composition_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipment_composition_stock (
    shipment_composition_stock_id integer DEFAULT nextval('public.shipment_composition_stock_id_seq'::regclass) NOT NULL,
    item_composition_master_id integer NOT NULL,
    depocd smallint NOT NULL,
    theory_stock smallint NOT NULL,
    warning_num smallint NOT NULL,
    attention_num smallint NOT NULL
);


ALTER TABLE public.s_shipment_composition_stock OWNER TO postgres;

--
-- Name: shipment_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipment_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipment_stock_id_seq OWNER TO postgres;

--
-- Name: s_shipment_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipment_stock (
    shipment_stock_id integer DEFAULT nextval('public.shipment_stock_id_seq'::regclass) NOT NULL,
    item_id integer NOT NULL,
    depocd smallint NOT NULL,
    theory_stock smallint NOT NULL,
    warning_num smallint NOT NULL,
    attention_num smallint NOT NULL
);


ALTER TABLE public.s_shipment_stock OWNER TO postgres;

--
-- Name: shipping_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_id_seq OWNER TO postgres;

--
-- Name: s_shipping; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping (
    shipping_id integer DEFAULT nextval('public.shipping_id_seq'::regclass) NOT NULL,
    shipping_no character varying(15) NOT NULL,
    shipment_origin_depocd integer NOT NULL,
    shipment_destination_depocd integer NOT NULL,
    delivery_depocd integer NOT NULL,
    shipment_request_date date NOT NULL,
    reports text,
    address character varying(255),
    tel character varying(15),
    fax character varying(15),
    delivered_desired_date date,
    shipment_date date,
    arrival_date date,
    person_in_charge character varying(15),
    status smallint NOT NULL,
    shipping_type character(1),
    parent_shipping_id integer,
    regist_name character varying(50) NOT NULL,
    regist_at timestamp without time zone NOT NULL,
    cancel_reason text,
    cancel_datetime timestamp without time zone,
    cancel_name character varying(50),
    reports_shipment text,
    shipment_genre smallint,
    shipment_reason smallint,
    shipment_reason_other text
);


ALTER TABLE public.s_shipping OWNER TO postgres;

--
-- Name: shipping_composition_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_composition_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_composition_detail_id_seq OWNER TO postgres;

--
-- Name: s_shipping_composition_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping_composition_detail (
    shipping_composition_detail_id integer DEFAULT nextval('public.shipping_composition_detail_id_seq'::regclass) NOT NULL,
    shipping_id integer NOT NULL,
    item_composition_master_id integer NOT NULL,
    shipment_request_num integer NOT NULL,
    shipment_num integer NOT NULL,
    arrival_num integer NOT NULL,
    remarks character varying(100),
    remarks_shipment character varying(100),
    remarks_depo character varying(100)
);


ALTER TABLE public.s_shipping_composition_detail OWNER TO postgres;

--
-- Name: shipping_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_detail_id_seq OWNER TO postgres;

--
-- Name: s_shipping_detail; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping_detail (
    shipping_detail_id integer DEFAULT nextval('public.shipping_detail_id_seq'::regclass) NOT NULL,
    shipping_id integer NOT NULL,
    item_id integer NOT NULL,
    proper_stock_num integer NOT NULL,
    shipment_request_num integer NOT NULL,
    shipment_num integer NOT NULL,
    arrival_num integer NOT NULL,
    remarks character varying(100),
    remarks_shipment character varying(100),
    remarks_depo character varying(100)
);


ALTER TABLE public.s_shipping_detail OWNER TO postgres;

--
-- Name: s_shipping_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping_group (
    group_id integer NOT NULL,
    depocd integer NOT NULL
);


ALTER TABLE public.s_shipping_group OWNER TO postgres;

--
-- Name: s_shipping_group_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping_group_master (
    group_id integer NOT NULL,
    group_name character varying(50) NOT NULL
);


ALTER TABLE public.s_shipping_group_master OWNER TO postgres;

--
-- Name: shipping_message_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_message_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shipping_message_id_seq OWNER TO postgres;

--
-- Name: s_shipping_message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_shipping_message (
    shipping_message_id integer DEFAULT nextval('public.shipping_message_id_seq'::regclass) NOT NULL,
    depocd integer NOT NULL,
    message character varying(500) NOT NULL,
    person_in_charge character varying(50) NOT NULL,
    view_flg smallint NOT NULL,
    regist_at timestamp without time zone NOT NULL
);


ALTER TABLE public.s_shipping_message OWNER TO postgres;

--
-- Name: stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stock_id_seq OWNER TO postgres;

--
-- Name: s_stock; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_stock (
    stock_id integer DEFAULT nextval('public.stock_id_seq'::regclass) NOT NULL,
    item_id integer NOT NULL,
    depocd integer NOT NULL,
    theory_stock integer NOT NULL,
    dead_stock integer NOT NULL,
    one_day_delivery smallint NOT NULL,
    two_day_delivery smallint NOT NULL,
    one_week_delivery smallint NOT NULL,
    one_month_delivery smallint NOT NULL
);


ALTER TABLE public.s_stock OWNER TO postgres;

--
-- Name: s_stock_depo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_stock_depo (
    depocd integer NOT NULL,
    settled_depocd integer NOT NULL,
    priority_shipment_origin_depocd integer NOT NULL,
    priority_shipment_destination_depocd integer NOT NULL,
    pref_id integer NOT NULL
);


ALTER TABLE public.s_stock_depo OWNER TO postgres;

--
-- Name: s_stock_depo_grouping; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_stock_depo_grouping (
    depocd integer NOT NULL,
    stock_manage_depocd integer NOT NULL
);


ALTER TABLE public.s_stock_depo_grouping OWNER TO postgres;

--
-- Name: s_stock_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_stock_history (
    hist_id integer DEFAULT nextval('public.hist_id_seq'::regclass) NOT NULL,
    depocd integer NOT NULL,
    item_id integer NOT NULL,
    before_theory_stock smallint NOT NULL,
    after_theory_stock smallint NOT NULL,
    reason text NOT NULL,
    change_name character varying(50) NOT NULL,
    s_update_at timestamp without time zone NOT NULL
);


ALTER TABLE public.s_stock_history OWNER TO postgres;

--
-- Name: s_stock_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_stock_item (
    item_id integer NOT NULL,
    object_flg smallint NOT NULL,
    end_object_years integer,
    view_position smallint,
    sort_no integer NOT NULL
);


ALTER TABLE public.s_stock_item OWNER TO postgres;

--
-- Name: threshold_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.threshold_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.threshold_id_seq OWNER TO postgres;

--
-- Name: s_threshold; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_threshold (
    threshold_id integer DEFAULT nextval('public.threshold_id_seq'::regclass) NOT NULL,
    district_id integer NOT NULL,
    item_id integer NOT NULL,
    warning smallint NOT NULL,
    attention smallint NOT NULL,
    threshold_range_id integer NOT NULL
);


ALTER TABLE public.s_threshold OWNER TO postgres;

--
-- Name: threshold_range_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.threshold_range_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.threshold_range_master_id_seq OWNER TO postgres;

--
-- Name: s_threshold_range_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_threshold_range_master (
    threshold_range_id integer DEFAULT nextval('public.threshold_range_master_id_seq'::regclass) NOT NULL,
    object_min integer NOT NULL,
    object_max integer NOT NULL
);


ALTER TABLE public.s_threshold_range_master OWNER TO postgres;

--
-- Name: to_depo_message_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.to_depo_message_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.to_depo_message_id_seq OWNER TO postgres;

--
-- Name: s_to_depo_message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.s_to_depo_message (
    message_id integer DEFAULT nextval('public.to_depo_message_id_seq'::regclass) NOT NULL,
    district_id integer,
    pref_id integer,
    depocd integer,
    message_group_id integer,
    message text NOT NULL,
    person_in_charge character varying(100) NOT NULL,
    view_limit date NOT NULL,
    regist_at timestamp without time zone NOT NULL
);


ALTER TABLE public.s_to_depo_message OWNER TO postgres;

--
-- Name: scat_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.scat_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.scat_id_seq OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: seikyuu_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seikyuu_data (
    s_cd integer,
    koumoku smallint,
    count integer,
    money integer,
    money1_tax_rate numeric(7,6),
    money1_count integer,
    money1 integer,
    money2_tax_rate numeric(7,6),
    money2_count integer,
    money2 integer
);


ALTER TABLE public.seikyuu_data OWNER TO postgres;

--
-- Name: seikyuu_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seikyuu_master (
    s_cd integer,
    s_year smallint,
    s_mon smallint,
    s_coid character varying(13),
    p_coid character varying(13),
    d_coid character varying(13),
    seikyuu character varying(2),
    seikyuufee character varying(2),
    check_date timestamp with time zone,
    sck_cd character varying(2),
    keiri_bikou character varying(60),
    custom_key integer,
    total1 integer,
    total2 integer,
    check_date_social timestamp with time zone,
    keiri_bikou_social character varying(60),
    total1_social integer,
    total2_social integer,
    s_flg character(1) DEFAULT '0'::bpchar NOT NULL
);


ALTER TABLE public.seikyuu_master OWNER TO postgres;

--
-- Name: seq_transaction; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seq_transaction
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.seq_transaction OWNER TO postgres;

--
-- Name: settle_corp_orderid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settle_corp_orderid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1
    CYCLE;


ALTER TABLE public.settle_corp_orderid_seq OWNER TO postgres;

--
-- Name: settle_depart_remark; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settle_depart_remark (
    s_cd integer NOT NULL,
    branch_number integer NOT NULL,
    depart_number integer,
    remark text,
    tantou character varying(30),
    update_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.settle_depart_remark OWNER TO postgres;

--
-- Name: settle_err_corp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settle_err_corp (
    shoporder_no character(27),
    s_cd integer,
    branch_number integer,
    tenantno character varying(2),
    money integer,
    token_expire_date character varying(14),
    v_result_code character varying(16),
    merr_msg text,
    err_date character(8),
    err_time character(8),
    veritrans_response text,
    settle_method smallint
);


ALTER TABLE public.settle_err_corp OWNER TO postgres;

--
-- Name: settle_res_corp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settle_res_corp (
    s_cd integer NOT NULL,
    branch_number integer NOT NULL,
    tranid character varying(100),
    trandate timestamp without time zone,
    tenantno character varying(2),
    amount integer,
    method character varying(2),
    paytimes character varying(2),
    approve character varying(7),
    orderid character(27),
    veritrans_response text,
    settle_method smallint
);


ALTER TABLE public.settle_res_corp OWNER TO postgres;

--
-- Name: sg_kaikan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sg_kaikan (
    kaikan_cd integer DEFAULT nextval(('sg_kaikan_seq'::text)::regclass),
    sg_id character varying(12),
    k_name character varying(60),
    k_post character varying(8),
    k_pref character varying(2),
    k_siku character varying(40),
    k_tyou character varying(100),
    k_addr character varying(100),
    k_build character varying(60),
    k_tel character varying(15),
    k_fax character varying(15),
    k_url character varying(100)
);


ALTER TABLE public.sg_kaikan OWNER TO postgres;

--
-- Name: sg_kaikan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sg_kaikan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sg_kaikan_seq OWNER TO postgres;

--
-- Name: sinwa_dbin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sinwa_dbin (
    send date,
    touroku timestamp with time zone,
    r_cnt integer
);


ALTER TABLE public.sinwa_dbin OWNER TO postgres;

--
-- Name: sinwa_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sinwa_item (
    s_code character varying(10),
    iname character varying(60),
    tanka numeric(6,2)
);


ALTER TABLE public.sinwa_item OWNER TO postgres;

--
-- Name: sinwa_sendto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sinwa_sendto (
    ordercd integer NOT NULL,
    ordernum smallint NOT NULL,
    sinwacode character varying(10),
    code_1 character varying(5),
    code_2 character varying(3),
    item character varying(40),
    fee1 integer NOT NULL,
    a_date date,
    m_name character varying(40),
    o_date date,
    fee2 integer NOT NULL,
    send date,
    kubun character varying(1) DEFAULT '0'::character varying
);


ALTER TABLE public.sinwa_sendto OWNER TO postgres;

--
-- Name: sinwacd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sinwacd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sinwacd_seq OWNER TO postgres;

--
-- Name: sinwacode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sinwacode (
    coid character varying(13) NOT NULL,
    sinwacd character varying(8),
    ck_mail boolean
);


ALTER TABLE public.sinwacode OWNER TO postgres;

--
-- Name: smbc_err; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.smbc_err (
    shoporder_no character(17),
    sendid integer,
    tenantno character varying(2),
    seikyuu_kingaku integer,
    rescd character(6),
    res character varying(256),
    err_date character(8),
    err_time character(6),
    kessai_no character(14),
    u_agent text
);


ALTER TABLE public.smbc_err OWNER TO postgres;

--
-- Name: smbc_res; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.smbc_res (
    shoporder_no character(17),
    sendid integer,
    shop_cd character(7),
    syuno_co_cd character varying(8),
    tranid character(14),
    trandate character(14),
    tenantno character varying(2),
    amount integer,
    method character varying(2),
    paytimes character varying(2),
    forward character varying(256),
    approve character varying(256),
    ordercd integer
);


ALTER TABLE public.smbc_res OWNER TO postgres;

--
-- Name: smnt_task; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.smnt_task (
    t_num integer,
    or_date date,
    st_date date,
    fi_date date,
    li_date date,
    status character varying(20),
    naiyou character varying(100),
    irai character varying(20),
    tantou character varying(20),
    target character varying(20),
    design_fin date,
    make_fin date,
    test_fin date,
    active boolean,
    pgm boolean,
    bikou character varying(100),
    kan1 character varying(20),
    kan2 character varying(20),
    kan3 character varying(20),
    kan4 character varying(20),
    kan5 character varying(20),
    kenmei character varying(100),
    tenpu boolean
);


ALTER TABLE public.smnt_task OWNER TO postgres;

--
-- Name: sub_barcode; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_barcode (
    sub_barcode_id integer DEFAULT nextval(('sub_barcode_id_seq'::text)::regclass) NOT NULL,
    sub_quest_cscd character varying(15) NOT NULL,
    sub_company_cd integer NOT NULL,
    collect_cnt smallint DEFAULT 0 NOT NULL,
    close_date date,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.sub_barcode OWNER TO postgres;

--
-- Name: sub_barcode_fix; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_barcode_fix (
    sub_barcode_fix_id integer DEFAULT nextval(('sub_barcode_fix_id_seq'::text)::regclass) NOT NULL,
    sub_barcode_fix_master_id integer NOT NULL,
    fix_group smallint NOT NULL,
    group_item integer NOT NULL,
    fix_01 character varying(4) NOT NULL,
    fix_02 character varying(4) NOT NULL,
    fix_03 character varying(4) NOT NULL,
    fix_04 character varying(4) NOT NULL,
    fix_05 character varying(4) NOT NULL,
    fix_06 character varying(4) NOT NULL,
    fix_07 character varying(4) NOT NULL,
    fix_08 character varying(4) NOT NULL,
    fix_09 character varying(4) NOT NULL,
    fix_10 character varying(4) NOT NULL,
    fix_11 character varying(4) NOT NULL,
    fix_12 character varying(4) NOT NULL,
    fix_13 character varying(4) NOT NULL,
    fix_14 character varying(4) NOT NULL,
    fix_15 character varying(4) NOT NULL,
    fix_16 character varying(4) NOT NULL,
    fix_17 character varying(4) NOT NULL,
    fix_18 character varying(4) NOT NULL,
    fix_19 character varying(4) NOT NULL,
    fix_20 character varying(4) NOT NULL,
    fix_21 character varying(4) NOT NULL,
    fix_22 character varying(4) NOT NULL,
    fix_23 character varying(4) NOT NULL,
    fix_24 character varying(4) NOT NULL,
    fix_25 character varying(4) NOT NULL,
    fix_26 character varying(4) NOT NULL,
    fix_27 character varying(4) NOT NULL,
    fix_28 character varying(4) NOT NULL,
    fix_29 character varying(4) NOT NULL,
    fix_30 character varying(4) NOT NULL,
    fix_31 character varying(4) NOT NULL
);


ALTER TABLE public.sub_barcode_fix OWNER TO postgres;

--
-- Name: sub_barcode_fix_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_barcode_fix_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.sub_barcode_fix_id_seq OWNER TO postgres;

--
-- Name: sub_barcode_fix_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_barcode_fix_master (
    sub_barcode_fix_master_id integer DEFAULT nextval(('sub_barcode_fix_master_id_seq'::text)::regclass) NOT NULL,
    depocd integer NOT NULL,
    year smallint NOT NULL,
    mon smallint NOT NULL,
    tantou character varying(60) NOT NULL,
    fix_at timestamp without time zone DEFAULT now() NOT NULL,
    ck_pdf boolean DEFAULT false NOT NULL,
    ck_date timestamp without time zone
);


ALTER TABLE public.sub_barcode_fix_master OWNER TO postgres;

--
-- Name: sub_barcode_fix_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_barcode_fix_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.sub_barcode_fix_master_id_seq OWNER TO postgres;

--
-- Name: sub_barcode_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_barcode_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.sub_barcode_id_seq OWNER TO postgres;

--
-- Name: sub_company_cd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_company_cd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.sub_company_cd_seq OWNER TO postgres;

--
-- Name: sub_company_master; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_company_master (
    sub_company_cd integer DEFAULT nextval(('sub_company_cd_seq'::text)::regclass) NOT NULL,
    sub_company_name character varying(60) NOT NULL,
    dsp_turn smallint NOT NULL,
    pursuit_url character varying(255),
    barcode_type character(1) NOT NULL,
    barcode_start_cd character(1),
    barcode_stop_cd character(1),
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.sub_company_master OWNER TO postgres;

--
-- Name: summary_save; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.summary_save (
    summary_save_id integer DEFAULT nextval(('summary_save_id_seq'::text)::regclass) NOT NULL,
    e_code integer NOT NULL,
    title character varying NOT NULL,
    d_code integer,
    condition text
);


ALTER TABLE public.summary_save OWNER TO postgres;

--
-- Name: summary_save_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.summary_save_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.summary_save_id_seq OWNER TO postgres;

--
-- Name: sys_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sys_order (
    s_num integer,
    e_code integer,
    or_date date,
    li_date date,
    title character varying(100),
    ac_date date,
    st_date date,
    fi_date date,
    check_1 date,
    check_2 date,
    check_3 date,
    pre_num integer,
    active boolean,
    bikou character varying(100),
    po_check boolean
);


ALTER TABLE public.sys_order OWNER TO postgres;

--
-- Name: tanabe_attr; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tanabe_attr (
    coid character varying(12),
    item_type character varying(2),
    attr_6 character varying(20),
    attr_7 character varying(20),
    attr_8 character varying(20),
    attr_9 character varying(20),
    attr_10 character varying(20)
);


ALTER TABLE public.tanabe_attr OWNER TO postgres;

--
-- Name: telephone_denial_company; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telephone_denial_company (
    coid character varying(12) NOT NULL,
    c_class character varying(2) NOT NULL,
    update_by character varying(60),
    update_at timestamp with time zone DEFAULT now(),
    permit boolean NOT NULL,
    remark text
);


ALTER TABLE public.telephone_denial_company OWNER TO postgres;

--
-- Name: tkc_code_tb; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tkc_code_tb (
    tkc_code integer,
    tkc_naiyou text,
    naiyou text,
    item_price1 integer,
    item_price2 integer
);


ALTER TABLE public.tkc_code_tb OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: tkc_code_tb_tmp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tkc_code_tb_tmp (
    tkc_code integer,
    tkc_naiyou text,
    naiyou text,
    item_price1 integer,
    item_price2 integer
);


ALTER TABLE public.tkc_code_tb_tmp OWNER TO postgres;

--
-- Name: tmpl_cond_link_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tmpl_cond_link_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tmpl_cond_link_id_seq OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: tos_b; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tos_b (
    admin_name character varying(60),
    c_branch character varying(60),
    tel_start character varying(15),
    tel_end character varying(15)
);


ALTER TABLE public.tos_b OWNER TO postgres;

--
-- Name: tos_c; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tos_c (
    admin_num integer NOT NULL,
    admin_name character varying(60),
    b_num integer NOT NULL,
    c_branch character varying(60),
    seikyuu character varying(2),
    mail_key character varying(20),
    ag_1 character varying(12),
    ag_2 character varying(12),
    ag_3 character varying(12)
);


ALTER TABLE public.tos_c OWNER TO postgres;

--
-- Name: tp_key_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tp_key_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tp_key_seq OWNER TO postgres;

--
-- Name: tsuban_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tsuban_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tsuban_seq OWNER TO postgres;

--
-- Name: unchin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.unchin (
    u_num integer DEFAULT nextval(('unchin_u_num_seq'::text)::regclass) NOT NULL,
    ordercd integer
);


ALTER TABLE public.unchin OWNER TO postgres;

--
-- Name: unchin_u_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unchin_u_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.unchin_u_num_seq OWNER TO postgres;

--
-- Name: undeliv; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.undeliv (
    undeliv_id integer DEFAULT nextval(('undeliv_id_seq'::text)::regclass),
    event text,
    depocd smallint,
    lcat_cd smallint,
    mcat_cd smallint,
    scat_cd smallint,
    item_cd character varying(10),
    check_type smallint,
    undeliv_type smallint,
    area_type smallint,
    time_ptn smallint,
    check_date date,
    check_begin date,
    check_end date,
    check_mon boolean,
    check_tue boolean,
    check_wed boolean,
    check_thu boolean,
    check_fri boolean,
    check_sat boolean,
    check_sun boolean,
    check_hol boolean,
    anno_begin date,
    anno_end date,
    anno_addr text,
    anno_period text,
    remark text,
    sp_flg boolean,
    permit boolean,
    check_hol_next boolean
);


ALTER TABLE public.undeliv OWNER TO postgres;

--
-- Name: undeliv_addr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.undeliv_addr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.undeliv_addr_id_seq OWNER TO postgres;

--
-- Name: undeliv_area; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.undeliv_area (
    undeliv_addr_id integer DEFAULT nextval(('undeliv_addr_id_seq'::text)::regclass) NOT NULL,
    undeliv_id integer NOT NULL,
    addrcd integer,
    pref character varying(2),
    siku character varying(40),
    tyou character varying(100),
    permit boolean DEFAULT true NOT NULL
);


ALTER TABLE public.undeliv_area OWNER TO postgres;

--
-- Name: undeliv_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.undeliv_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.undeliv_id_seq OWNER TO postgres;

--
-- Name: undeliv_item_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.undeliv_item_opt (
    undeliv_id integer NOT NULL,
    huda_type character varying(2),
    handing character varying(2)
);


ALTER TABLE public.undeliv_item_opt OWNER TO postgres;

--
-- Name: undeliv_opt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.undeliv_opt (
    undeliv_id integer NOT NULL,
    c_use smallint,
    c_other character varying(60)
);


ALTER TABLE public.undeliv_opt OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: user_auth_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_auth_status (
    user_id character varying(120) NOT NULL,
    site_type smallint NOT NULL,
    fail_count smallint DEFAULT 0 NOT NULL,
    status smallint DEFAULT 0 NOT NULL,
    update timestamp without time zone DEFAULT now()
);


ALTER TABLE public.user_auth_status OWNER TO postgres;

--
-- Name: user_auth_stg; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_auth_stg (
    name character varying(120) NOT NULL,
    value character varying(120),
    description text
);


ALTER TABLE public.user_auth_stg OWNER TO postgres;

--
-- Name: user_cd_usercd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_cd_usercd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.user_cd_usercd_seq OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: usercd; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usercd (
    usercd integer DEFAULT nextval(('user_cd_usercd_seq'::text)::regclass),
    coid character varying(12),
    pass character varying(20),
    u_name character varying(60),
    u_tel character varying(15),
    u_fax character varying(15),
    u_mail character varying(50),
    u_branch character varying(60),
    u_section character varying(60),
    u_group character varying(60),
    u_yaku character varying(60),
    admin boolean,
    enable boolean
);


ALTER TABLE public.usercd OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: vc_order; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vc_order (
    ordercd integer,
    ordernum smallint,
    depocd smallint,
    disable character varying(2),
    daisi character varying(1),
    cardcd character varying(4),
    fonts character varying(1),
    c_title1 character varying(60),
    c_title2 character varying(60),
    c_title3 character varying(60),
    c_keisho1 character varying(12),
    c_keisho2 character varying(12),
    c_keisho3 character varying(12),
    c_mes1 character varying(62),
    c_mes2 character varying(62),
    c_mes3 character varying(62),
    c_mes4 character varying(62),
    c_mes5 character varying(62),
    c_mes6 character varying(62),
    c_mes7 character varying(62),
    c_mes8 character varying(62),
    c_mes9 character varying(62),
    c_mes10 character varying(62),
    c_from1 character varying(60),
    c_from2 character varying(60),
    c_from3 character varying(60),
    fimgcd character varying(4),
    ck_order boolean,
    ip_addr cidr,
    d_name character varying(40),
    ck_date timestamp with time zone,
    leadtime smallint,
    direction character varying(1),
    c_title4 character varying(60) DEFAULT ''::character varying,
    c_keisho4 character varying(12),
    c_from4 character varying(60) DEFAULT ''::character varying
);


ALTER TABLE public.vc_order OWNER TO postgres;

--
-- Name: vc_order_old; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vc_order_old (
    ordercd integer,
    ordernum smallint,
    depocd smallint,
    disable character varying(2),
    daisi character varying(1),
    cardcd character varying(4),
    fonts character varying(1),
    c_title1 character varying(60),
    c_title2 character varying(60),
    c_title3 character varying(60),
    c_keisho1 character varying(12),
    c_keisho2 character varying(12),
    c_keisho3 character varying(12),
    c_mes1 character varying(62),
    c_mes2 character varying(62),
    c_mes3 character varying(62),
    c_mes4 character varying(62),
    c_mes5 character varying(62),
    c_mes6 character varying(62),
    c_mes7 character varying(62),
    c_mes8 character varying(62),
    c_mes9 character varying(62),
    c_mes10 character varying(62),
    c_from1 character varying(60),
    c_from2 character varying(60),
    c_from3 character varying(60),
    fimgcd character varying(4),
    ck_order boolean,
    ip_addr cidr,
    d_name character varying(40),
    ck_date timestamp with time zone,
    leadtime smallint,
    direction character varying(1),
    c_title4 character varying(60),
    c_keisho4 character varying(12),
    c_from4 character varying(60)
);


ALTER TABLE public.vc_order_old OWNER TO postgres;

--
-- Name: vc_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vc_test (
    ordercd integer,
    ordernum smallint,
    depocd smallint,
    disable character varying(2),
    daisi character varying(1),
    cardcd character varying(4),
    fonts character varying(1),
    c_title1 character varying(60),
    c_title2 character varying(60),
    c_title3 character varying(60),
    c_keisho1 character varying(12),
    c_keisho2 character varying(12),
    c_keisho3 character varying(12),
    c_mes1 character varying(62),
    c_mes2 character varying(62),
    c_mes3 character varying(62),
    c_mes4 character varying(62),
    c_mes5 character varying(62),
    c_mes6 character varying(62),
    c_mes7 character varying(62),
    c_mes8 character varying(62),
    c_mes9 character varying(62),
    c_mes10 character varying(62),
    c_from1 character varying(60),
    c_from2 character varying(60),
    c_from3 character varying(60),
    fimgcd character varying(4),
    ck_order boolean,
    ip_addr cidr,
    d_name character varying(40),
    ck_date timestamp with time zone,
    leadtime smallint,
    direction character varying(1),
    c_title4 character varying(60),
    c_keisho4 character varying(12),
    c_from4 character varying(60)
);


ALTER TABLE public.vc_test OWNER TO postgres;

--
-- Name: veritrans_err; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.veritrans_err (
    shoporder_no character(27),
    sendid integer,
    tenantno character varying(2),
    money integer,
    token_expire_date character varying(14),
    v_result_code character varying(16),
    merr_msg text,
    err_date character(8),
    err_time character(8),
    veritrans_response text
);


ALTER TABLE public.veritrans_err OWNER TO postgres;

--
-- Name: view_deliv_list; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_deliv_list AS
 SELECT vc_order.depocd,
    depocd.deponame,
    item_all.item_id,
    order_master.a_date,
    count(order_master.a_date) AS count
   FROM (((( SELECT order_master_1.a_date,
            order_master_1.ordercd,
            order_master_1.item_type,
            order_master_1.permit,
            order_master_1.ordernum
           FROM public.order_master order_master_1) order_master
     JOIN ( SELECT vc_order_1.depocd,
                CASE
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP2'::character varying)::text, ('BMP2'::character varying)::text, ('BLP2'::character varying)::text])) THEN 'POP2'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSBW'::character varying)::text, ('BMBW'::character varying)::text, ('BLBW'::character varying)::text])) THEN 'BW01'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP3'::character varying)::text, ('BMP3'::character varying)::text, ('BLP3'::character varying)::text])) THEN 'POP3'::character varying
                    ELSE vc_order_1.cardcd
                END AS cardcd,
            vc_order_1.ordercd,
            vc_order_1.ordernum
           FROM public.vc_order vc_order_1) vc_order ON (((order_master.ordercd = vc_order.ordercd) AND (order_master.ordernum = vc_order.ordernum))))
     JOIN public.depocd ON ((vc_order.depocd = depocd.depocd)))
     JOIN public.item_all ON (((vc_order.cardcd)::text = (item_all.item_cd)::text)))
  WHERE ((order_master.permit = true) AND ((order_master.item_type)::text = ANY (ARRAY['1'::text, '17'::text])))
  GROUP BY vc_order.depocd, item_all.item_id, depocd.deponame, order_master.a_date
  ORDER BY vc_order.depocd, item_all.item_id;


ALTER TABLE public.view_deliv_list OWNER TO postgres;

--
-- Name: view_s_stock_enable; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_s_stock_enable AS
 SELECT item_all.item_id,
    item_all.item_nm,
    depocd.depocd AS settled_depocd,
    s_stock_depo.depocd,
    depocd.deponame,
    s_stock_item.view_position,
    s_stock_item.sort_no,
    s_stock.stock_id,
    s_stock.theory_stock,
    s_stock.one_day_delivery,
    s_stock.two_day_delivery,
    s_stock.one_week_delivery,
    s_stock.one_month_delivery,
        CASE
            WHEN (s_stock_item.object_flg = 1) THEN 1
            WHEN ((s_stock_item.end_object_years)::numeric >= to_number(to_char(now(), 'YYYYMM'::text), '999999'::text)) THEN 1
            ELSE 0
        END AS end_of_manage
   FROM ((((public.s_stock
     JOIN public.s_stock_depo ON ((s_stock.depocd = s_stock_depo.settled_depocd)))
     JOIN public.s_stock_item ON ((s_stock.item_id = s_stock_item.item_id)))
     JOIN public.depocd ON ((s_stock.depocd = depocd.depocd)))
     JOIN public.item_all ON ((s_stock.item_id = item_all.item_id)))
  WHERE (depocd.stop = false);


ALTER TABLE public.view_s_stock_enable OWNER TO postgres;

--
-- Name: view_alert_item; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_alert_item AS
 SELECT DISTINCT view_s_stock_enable.stock_id,
    view_s_stock_enable.settled_depocd,
    view_s_stock_enable.deponame,
    view_s_stock_enable.item_id,
    view_s_stock_enable.item_nm,
    view_s_stock_enable.theory_stock,
    s_proper_stock.warning_num,
    s_proper_stock.attention_num,
    s_proper_stock.object_years,
    deliv.count,
    to_number(to_char(now(), 'YYYYMM'::text), '999999'::text) AS now_date,
        CASE
            WHEN (((view_s_stock_enable.theory_stock)::numeric - deliv.count) <= (s_proper_stock.warning_num)::numeric) THEN 1
            WHEN (view_s_stock_enable.theory_stock <= s_proper_stock.warning_num) THEN 1
            WHEN (((view_s_stock_enable.theory_stock)::numeric - deliv.count) <= (s_proper_stock.attention_num)::numeric) THEN 2
            WHEN (view_s_stock_enable.theory_stock <= s_proper_stock.attention_num) THEN 2
            WHEN ((view_s_stock_enable.theory_stock - view_s_stock_enable.two_day_delivery) <= s_proper_stock.warning_num) THEN 3
            WHEN ((view_s_stock_enable.theory_stock - view_s_stock_enable.two_day_delivery) <= s_proper_stock.attention_num) THEN 4
            ELSE 0
        END AS alert_flg
   FROM ((public.view_s_stock_enable
     JOIN public.s_proper_stock ON ((view_s_stock_enable.stock_id = s_proper_stock.stock_id)))
     LEFT JOIN ( SELECT view_s_stock_enable_1.settled_depocd,
            view_deliv_list.item_id,
            sum(view_deliv_list.count) AS count
           FROM public.view_s_stock_enable view_s_stock_enable_1,
            public.view_deliv_list
          WHERE ((view_s_stock_enable_1.depocd = view_deliv_list.depocd) AND (view_s_stock_enable_1.item_id = view_deliv_list.item_id) AND ((view_deliv_list.a_date)::text = to_char(now(), 'YYYY-MM-DD'::text)))
          GROUP BY view_s_stock_enable_1.settled_depocd, view_deliv_list.item_id) deliv ON (((view_s_stock_enable.item_id = deliv.item_id) AND (view_s_stock_enable.settled_depocd = deliv.settled_depocd))))
  WHERE ((s_proper_stock.object_years)::numeric = to_number(to_char(now(), 'YYYYMMDD'::text), '999999'::text))
  ORDER BY view_s_stock_enable.settled_depocd, view_s_stock_enable.item_id, view_s_stock_enable.stock_id, view_s_stock_enable.deponame, view_s_stock_enable.item_nm, view_s_stock_enable.theory_stock, s_proper_stock.warning_num, s_proper_stock.attention_num, s_proper_stock.object_years, (to_number(to_char(now(), 'YYYYMM'::text), '999999'::text)),
        CASE
            WHEN (((view_s_stock_enable.theory_stock)::numeric - deliv.count) <= (s_proper_stock.warning_num)::numeric) THEN 1
            WHEN (view_s_stock_enable.theory_stock <= s_proper_stock.warning_num) THEN 1
            WHEN (((view_s_stock_enable.theory_stock)::numeric - deliv.count) <= (s_proper_stock.attention_num)::numeric) THEN 2
            WHEN (view_s_stock_enable.theory_stock <= s_proper_stock.attention_num) THEN 2
            WHEN ((view_s_stock_enable.theory_stock - view_s_stock_enable.two_day_delivery) <= s_proper_stock.warning_num) THEN 3
            WHEN ((view_s_stock_enable.theory_stock - view_s_stock_enable.two_day_delivery) <= s_proper_stock.attention_num) THEN 4
            ELSE 0
        END, deliv.count;


ALTER TABLE public.view_alert_item OWNER TO postgres;

--
-- Name: view_deliv_list_was_delivery; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_deliv_list_was_delivery AS
 SELECT vc_order.depocd,
    depocd.deponame,
    item_all.item_id,
    order_master.a_date,
    count(order_master.a_date) AS count
   FROM (((( SELECT order_master_1.a_date,
            order_master_1.ordercd,
            order_master_1.item_type,
            order_master_1.permit,
            order_master_1.ordernum
           FROM public.order_master order_master_1) order_master
     JOIN ( SELECT vc_order_1.depocd,
                CASE
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP2'::character varying)::text, ('BMP2'::character varying)::text, ('BLP2'::character varying)::text])) THEN 'POP2'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSBW'::character varying)::text, ('BMBW'::character varying)::text, ('BLBW'::character varying)::text])) THEN 'BW01'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP3'::character varying)::text, ('BMP3'::character varying)::text, ('BLP3'::character varying)::text])) THEN 'POP3'::character varying
                    ELSE vc_order_1.cardcd
                END AS cardcd,
            vc_order_1.ordercd,
            vc_order_1.ck_order,
            vc_order_1.ordernum
           FROM public.vc_order vc_order_1) vc_order ON (((order_master.ordercd = vc_order.ordercd) AND (order_master.ordernum = vc_order.ordernum))))
     JOIN public.depocd ON ((vc_order.depocd = depocd.depocd)))
     JOIN public.item_all ON (((vc_order.cardcd)::text = (item_all.item_cd)::text)))
  WHERE ((order_master.permit = true) AND ((order_master.item_type)::text = ANY (ARRAY['1'::text, '17'::text])) AND (vc_order.ck_order = true))
  GROUP BY vc_order.depocd, item_all.item_id, depocd.deponame, order_master.a_date
  ORDER BY vc_order.depocd, item_all.item_id;


ALTER TABLE public.view_deliv_list_was_delivery OWNER TO postgres;

--
-- Name: view_deliv_list_was_delivery_old; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_deliv_list_was_delivery_old AS
 SELECT vc_order.depocd,
    depocd.deponame,
    item_all.item_id,
    order_master.a_date,
    count(order_master.a_date) AS count
   FROM (((( SELECT order_master_old.a_date,
            order_master_old.ordercd,
            order_master_old.item_type,
            order_master_old.permit
           FROM public.order_master_old) order_master
     JOIN ( SELECT vc_order_old.depocd,
            vc_order_old.cardcd,
            vc_order_old.ordercd,
            vc_order_old.ck_order
           FROM public.vc_order_old) vc_order ON ((order_master.ordercd = vc_order.ordercd)))
     JOIN public.depocd ON ((vc_order.depocd = depocd.depocd)))
     JOIN public.item_all_bk item_all ON (((vc_order.cardcd)::text = (item_all.item_cd)::text)))
  WHERE ((order_master.permit = true) AND ((order_master.item_type)::text = '1'::text) AND (vc_order.ck_order = true))
  GROUP BY vc_order.depocd, item_all.item_id, depocd.deponame, order_master.a_date
  ORDER BY vc_order.depocd, item_all.item_id;


ALTER TABLE public.view_deliv_list_was_delivery_old OWNER TO postgres;

--
-- Name: view_deliv_list_with_zipcode; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_deliv_list_with_zipcode AS
 SELECT vc_order.depocd,
    depocd.deponame,
    item_all.item_id,
    order_master.a_date,
    count(order_master.a_date) AS count,
    order_data.a_post
   FROM ((((( SELECT order_master_1.a_date,
            order_master_1.ordercd,
            order_master_1.item_type,
            order_master_1.permit,
            order_master_1.ordernum
           FROM public.order_master order_master_1
        UNION ALL
         SELECT order_master_old.a_date,
            order_master_old.ordercd,
            order_master_old.item_type,
            order_master_old.permit,
            order_master_old.ordernum
           FROM public.order_master_old) order_master
     JOIN ( SELECT vc_order_1.depocd,
                CASE
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP2'::character varying)::text, ('BMP2'::character varying)::text, ('BLP2'::character varying)::text])) THEN 'POP2'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSBW'::character varying)::text, ('BMBW'::character varying)::text, ('BLBW'::character varying)::text])) THEN 'BW01'::character varying
                    WHEN ((vc_order_1.cardcd)::text = ANY (ARRAY[('BSP3'::character varying)::text, ('BMP3'::character varying)::text, ('BLP3'::character varying)::text])) THEN 'POP3'::character varying
                    ELSE vc_order_1.cardcd
                END AS cardcd,
            vc_order_1.ordercd,
            vc_order_1.ordernum
           FROM public.vc_order vc_order_1
          WHERE (vc_order_1.ck_order = true)
        UNION ALL
         SELECT vc_order_old.depocd,
                CASE
                    WHEN ((vc_order_old.cardcd)::text = ANY (ARRAY[('BSP2'::character varying)::text, ('BMP2'::character varying)::text, ('BLP2'::character varying)::text])) THEN 'POP2'::character varying
                    WHEN ((vc_order_old.cardcd)::text = ANY (ARRAY[('BSBW'::character varying)::text, ('BMBW'::character varying)::text, ('BLBW'::character varying)::text])) THEN 'BW01'::character varying
                    WHEN ((vc_order_old.cardcd)::text = ANY (ARRAY[('BSP3'::character varying)::text, ('BMP3'::character varying)::text, ('BLP3'::character varying)::text])) THEN 'POP3'::character varying
                    ELSE vc_order_old.cardcd
                END AS cardcd,
            vc_order_old.ordercd,
            vc_order_old.ordernum
           FROM public.vc_order_old
          WHERE (vc_order_old.ck_order = true)) vc_order ON (((order_master.ordercd = vc_order.ordercd) AND (order_master.ordernum = vc_order.ordernum))))
     JOIN ( SELECT order_data_1.a_post,
            order_data_1.ordercd
           FROM public.order_data order_data_1
        UNION ALL
         SELECT order_data_old.a_post,
            order_data_old.ordercd
           FROM public.order_data_old) order_data ON ((order_master.ordercd = order_data.ordercd)))
     JOIN public.depocd ON ((vc_order.depocd = depocd.depocd)))
     JOIN public.item_all ON (((vc_order.cardcd)::text = (item_all.item_cd)::text)))
  WHERE ((order_master.permit = true) AND ((order_master.item_type)::text = ANY (ARRAY['1'::text, '17'::text])))
  GROUP BY vc_order.depocd, item_all.item_id, depocd.deponame, order_master.a_date, order_data.a_post
  ORDER BY vc_order.depocd, item_all.item_id;


ALTER TABLE public.view_deliv_list_with_zipcode OWNER TO postgres;

--
-- Name: voice; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.voice (
    v_cd integer NOT NULL,
    v_date timestamp with time zone,
    v_naiyou text,
    v_sei character varying(1),
    v_age character varying(1),
    permit boolean DEFAULT false
);


ALTER TABLE public.voice OWNER TO postgres;

--
-- Name: yoyaku; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.yoyaku (
    b_cd integer,
    b_date timestamp with time zone,
    b_pref character varying(2),
    b_siku character varying(40),
    b_tyou character varying(100),
    o_depo integer,
    o_time integer,
    n_depo integer,
    n_time integer,
    b_tantou character varying(20),
    in_date timestamp with time zone,
    bikou character varying(60),
    flg character varying(2)
);


ALTER TABLE public.yoyaku OWNER TO postgres;

--
-- Name: zeus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.zeus (
    zeuscd integer DEFAULT nextval(('zeuscd_seq'::text)::regclass) NOT NULL,
    usercd integer,
    cardcd character varying(4),
    daisi character varying(2),
    fonts character varying(2),
    a_pref character varying(2),
    a_siku character varying(20),
    a_tyou character varying(80),
    a_addr character varying(100),
    a_build character varying(100),
    a_post character varying(8),
    disable character varying(2),
    depocd smallint,
    a_date timestamp with time zone,
    tlimit boolean,
    cerehall character varying(100),
    c_date timestamp with time zone,
    c_time character varying(12),
    a_name character varying(60),
    a_tel character varying(15),
    m_coname character varying(80),
    m_branch character varying(80),
    m_section character varying(80),
    m_yaku character varying(80),
    m_name character varying(80),
    m_pref character varying(2),
    m_addr character varying(100),
    m_build character varying(100),
    m_post character varying(8),
    m_tel character varying(15),
    m_fax character varying(15),
    m_mail character varying(50),
    siharai character varying(2),
    o_type character varying(2),
    c_money integer,
    giftcd character varying(12),
    g_money integer,
    accesscd integer,
    o_bikou character varying(60),
    kinen character varying(2),
    leadtime smallint,
    cam_flg boolean DEFAULT false NOT NULL,
    a_keisho character varying(60),
    a_name2 character varying(60) DEFAULT ''::character varying,
    a_keisho2 character varying(60),
    c_use smallint,
    c_other character varying(60),
    c_flg boolean,
    a_time character varying(10)
);


ALTER TABLE public.zeus OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: zeus_etc_data; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.zeus_etc_data (
    zeuscd integer NOT NULL,
    etc_info_1 character varying(100),
    etc_info_2 character varying(100),
    etc_info_3 character varying(100),
    etc_info_4 character varying(100),
    etc_info_5 character varying(100),
    etc_info_6 character varying(100),
    etc_info_7 character varying(100),
    etc_info_8 character varying(100),
    etc_info_9 character varying(100),
    etc_info_10 character varying(100),
    v_order_pass character varying
);


ALTER TABLE public.zeus_etc_data OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: zeuscd_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.zeuscd_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2147483647
    CACHE 1;


ALTER TABLE public.zeuscd_seq OWNER TO postgres;

--
-- Name: disable_lock id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disable_lock ALTER COLUMN id SET DEFAULT nextval('public.disable_lock_id_seq'::regclass);


--
-- Name: display_master display_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.display_master ALTER COLUMN display_id SET DEFAULT nextval('public.display_master_display_id_seq'::regclass);


--
-- Name: log_info log_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_info ALTER COLUMN log_id SET DEFAULT nextval('public.log_info_log_id_seq'::regclass);


--
-- Name: address_book address_book_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.address_book
    ADD CONSTRAINT address_book_pkey PRIMARY KEY (address_book_id);


--
-- Name: agent_summary_id_tb agent_summary_id_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.agent_summary_id_tb
    ADD CONSTRAINT agent_summary_id_tb_pkey PRIMARY KEY (coid);


--
-- Name: bank_account bank_account_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bank_account
    ADD CONSTRAINT bank_account_pkey PRIMARY KEY (bank_account_id);


--
-- Name: bank_master bank_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bank_master
    ADD CONSTRAINT bank_master_pkey PRIMARY KEY (bank_cd, branch_cd);


--
-- Name: bikou_tb bikou_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bikou_tb
    ADD CONSTRAINT bikou_tb_pkey PRIMARY KEY (coid);


--
-- Name: bill_category_plan_master bill_category_plan_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_category_plan_master
    ADD CONSTRAINT bill_category_plan_master_pkey PRIMARY KEY (bill_category_plan_master_id);


--
-- Name: bill_category_plan_relation bill_category_plan_relation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_category_plan_relation
    ADD CONSTRAINT bill_category_plan_relation_pkey PRIMARY KEY (bill_category_plan_master_id, bill_mcat_id);


--
-- Name: bill_item_mcat_relation bill_item_mcat_relation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_item_mcat_relation
    ADD CONSTRAINT bill_item_mcat_relation_pkey PRIMARY KEY (mcat_cd);


--
-- Name: bill_lcat_data bill_lcat_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_lcat_data
    ADD CONSTRAINT bill_lcat_data_pkey PRIMARY KEY (s_cd, bill_lcat_id);


--
-- Name: bill_lcat bill_lcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_lcat
    ADD CONSTRAINT bill_lcat_pkey PRIMARY KEY (bill_lcat_id);


--
-- Name: bill_mcat bill_mcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_mcat
    ADD CONSTRAINT bill_mcat_pkey PRIMARY KEY (bill_mcat_id);


--
-- Name: bill_opt_general_account bill_opt_general_account_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_opt_general_account
    ADD CONSTRAINT bill_opt_general_account_pkey PRIMARY KEY (s_cd, bank_account_id);


--
-- Name: bill_opt bill_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bill_opt
    ADD CONSTRAINT bill_opt_pkey PRIMARY KEY (s_cd);


--
-- Name: c_biz c_biz_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.c_biz
    ADD CONSTRAINT c_biz_pkey PRIMARY KEY (biz_id);


--
-- Name: c_contact c_contact_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.c_contact
    ADD CONSTRAINT c_contact_pkey PRIMARY KEY (contact_id);


--
-- Name: c_scale c_scale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.c_scale
    ADD CONSTRAINT c_scale_pkey PRIMARY KEY (scale_id);


--
-- Name: c_user_temporary c_user_temporary_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.c_user_temporary
    ADD CONSTRAINT c_user_temporary_pkey PRIMARY KEY (temporary_id);


--
-- Name: campaign_list campaign_list_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaign_list
    ADD CONSTRAINT campaign_list_pkey PRIMARY KEY (cam_num);


--
-- Name: campaign campaign_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaign
    ADD CONSTRAINT campaign_pkey PRIMARY KEY (cam_cd);


--
-- Name: class1_menu_tb class1_menu_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.class1_menu_tb
    ADD CONSTRAINT class1_menu_tb_pkey PRIMARY KEY (class1_menu_id);


--
-- Name: class2_menu_tb class2_menu_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.class2_menu_tb
    ADD CONSTRAINT class2_menu_tb_pkey PRIMARY KEY (class2_menu_id);


--
-- Name: class3_menu_tb class3_menu_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.class3_menu_tb
    ADD CONSTRAINT class3_menu_tb_pkey PRIMARY KEY (class3_menu_id);


--
-- Name: coid_price_master coid_price_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coid_price_master
    ADD CONSTRAINT coid_price_master_pkey PRIMARY KEY (coid);


--
-- Name: column_category column_category_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.column_category
    ADD CONSTRAINT column_category_pkey PRIMARY KEY (column_category_id);


--
-- Name: column_data column_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.column_data
    ADD CONSTRAINT column_pkey PRIMARY KEY (column_data_id);


--
-- Name: company_account_lock_stg company_account_lock_stg_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_account_lock_stg
    ADD CONSTRAINT company_account_lock_stg_pkey PRIMARY KEY (coid);


--
-- Name: company_bill_destination company_bill_destination_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_bill_destination
    ADD CONSTRAINT company_bill_destination_pkey PRIMARY KEY (coid, bill_lcat_id);


--
-- Name: company_general_account company_general_account_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_general_account
    ADD CONSTRAINT company_general_account_pkey PRIMARY KEY (coid, bank_account_id);


--
-- Name: company_opt company_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_opt
    ADD CONSTRAINT company_opt_pkey PRIMARY KEY (coid);


--
-- Name: company_settle company_settle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_settle
    ADD CONSTRAINT company_settle_pkey PRIMARY KEY (coid);


--
-- Name: company_special_type company_special_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company_special_type
    ADD CONSTRAINT company_special_type_pkey PRIMARY KEY (coid);


--
-- Name: cs_template_cond_link cs_template_cond_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_cond_link
    ADD CONSTRAINT cs_template_cond_link_pkey PRIMARY KEY (tmpl_cond_link_id);


--
-- Name: cs_template_cond cs_template_cond_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_cond
    ADD CONSTRAINT cs_template_cond_pkey PRIMARY KEY (cond_id);


--
-- Name: cs_template_master cs_template_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_master
    ADD CONSTRAINT cs_template_master_pkey PRIMARY KEY (tmpl_id);


--
-- Name: cs_template_master cs_template_master_tmpl_no_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_master
    ADD CONSTRAINT cs_template_master_tmpl_no_key UNIQUE (tmpl_no);


--
-- Name: cs_template_cond_link cs_tmpl_cond_id_uniq_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_cond_link
    ADD CONSTRAINT cs_tmpl_cond_id_uniq_key UNIQUE (tmpl_id, cond_id);


--
-- Name: cust_cd_num cust_cd_num_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cust_cd_num
    ADD CONSTRAINT cust_cd_num_pkey PRIMARY KEY (cust_cd_num_id);


--
-- Name: depo_barcode depo_barcode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.depo_barcode
    ADD CONSTRAINT depo_barcode_pkey PRIMARY KEY (quest_id);


--
-- Name: depo_barcode_used depo_barcode_used_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.depo_barcode_used
    ADD CONSTRAINT depo_barcode_used_pkey PRIMARY KEY (quest_id);


--
-- Name: depo_class depo_class_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.depo_class
    ADD CONSTRAINT depo_class_pkey PRIMARY KEY (class_id);


--
-- Name: depo_item depo_item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.depo_item
    ADD CONSTRAINT depo_item_pkey PRIMARY KEY (depo_item_id);


--
-- Name: disable_lock disable_lock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disable_lock
    ADD CONSTRAINT disable_lock_pkey PRIMARY KEY (id, access_usercd, site_type);


--
-- Name: disp_custom disp_custom_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.disp_custom
    ADD CONSTRAINT disp_custom_pkey PRIMARY KEY (d_cd);


--
-- Name: display_master display_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.display_master
    ADD CONSTRAINT display_master_pkey PRIMARY KEY (display_id);


--
-- Name: fast_deliv_mng_c_use fast_deliv_mng_c_use_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fast_deliv_mng_c_use
    ADD CONSTRAINT fast_deliv_mng_c_use_pkey PRIMARY KEY (fast_deliv_mng_id, c_use);


--
-- Name: fast_deliv_mng_depocd fast_deliv_mng_depocd_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fast_deliv_mng_depocd
    ADD CONSTRAINT fast_deliv_mng_depocd_pkey PRIMARY KEY (fast_deliv_mng_id, depocd);


--
-- Name: fast_deliv_mng fast_deliv_mng_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fast_deliv_mng
    ADD CONSTRAINT fast_deliv_mng_pkey PRIMARY KEY (fast_deliv_mng_id);


--
-- Name: gmo_sys_errinfo_tb gmo_sys_errinfo_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gmo_sys_errinfo_tb
    ADD CONSTRAINT gmo_sys_errinfo_tb_pkey PRIMARY KEY (errinfo);


--
-- Name: hikiotoshi hikiotoshi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hikiotoshi
    ADD CONSTRAINT hikiotoshi_pkey PRIMARY KEY (coid);


--
-- Name: income_cedyna income_cedyna_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.income_cedyna
    ADD CONSTRAINT income_cedyna_pkey PRIMARY KEY (in_cd);


--
-- Name: information_board information_board_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.information_board
    ADD CONSTRAINT information_board_pkey PRIMARY KEY (info_id);


--
-- Name: item_addition_choice_link item_addition_choice_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_addition_choice_link
    ADD CONSTRAINT item_addition_choice_link_pkey PRIMARY KEY (item_addition_choice_link_id);


--
-- Name: item_addition_choice item_addition_choice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_addition_choice
    ADD CONSTRAINT item_addition_choice_pkey PRIMARY KEY (item_addition_choice_id);


--
-- Name: item_addition item_addition_item_addition_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_addition
    ADD CONSTRAINT item_addition_item_addition_key_key UNIQUE (item_addition_key);


--
-- Name: item_addition_link item_addition_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_addition_link
    ADD CONSTRAINT item_addition_link_pkey PRIMARY KEY (item_addition_link_id);


--
-- Name: item_addition item_addition_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_addition
    ADD CONSTRAINT item_addition_pkey PRIMARY KEY (item_addition_id);


--
-- Name: item_all_140117 item_all_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

-- ALTER TABLE ONLY public.item_all_140117
--    ADD CONSTRAINT item_all_pkey PRIMARY KEY (item_id);


--
-- Name: item_filter_coid item_filter_coid_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_filter_coid
    ADD CONSTRAINT item_filter_coid_pkey PRIMARY KEY (item_filter_coid_id);


--
-- Name: item_filter_ex item_filter_ex_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_filter_ex
    ADD CONSTRAINT item_filter_ex_pkey PRIMARY KEY (item_filter_ex_id);


--
-- Name: item_filter_price item_filter_price_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_filter_price
    ADD CONSTRAINT item_filter_price_pkey PRIMARY KEY (item_filter_price_id);


--
-- Name: item_group_choice_link item_group_choice_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_group_choice_link
    ADD CONSTRAINT item_group_choice_link_pkey PRIMARY KEY (item_group_choice_link_id);


--
-- Name: item_group_choice item_group_choice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_group_choice
    ADD CONSTRAINT item_group_choice_pkey PRIMARY KEY (item_group_choice_id);


--
-- Name: item_group item_group_item_group_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_group
    ADD CONSTRAINT item_group_item_group_key_key UNIQUE (item_group_key);


--
-- Name: item_group item_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_group
    ADD CONSTRAINT item_group_pkey PRIMARY KEY (item_group_id);


--
-- Name: item_lcat item_lcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_lcat
    ADD CONSTRAINT item_lcat_pkey PRIMARY KEY (lcat_id);


--
-- Name: item_mcat item_mcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_mcat
    ADD CONSTRAINT item_mcat_pkey PRIMARY KEY (mcat_id);


--
-- Name: item_opt_choice item_opt_choice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_opt_choice
    ADD CONSTRAINT item_opt_choice_pkey PRIMARY KEY (item_opt_choice_id);


--
-- Name: item_opt item_opt_item_opt_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_opt
    ADD CONSTRAINT item_opt_item_opt_key_key UNIQUE (item_opt_key);


--
-- Name: item_opt_link item_opt_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_opt_link
    ADD CONSTRAINT item_opt_link_pkey PRIMARY KEY (item_opt_link_id);


--
-- Name: item_opt item_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_opt
    ADD CONSTRAINT item_opt_pkey PRIMARY KEY (item_opt_id);


--
-- Name: item_ranking item_ranking_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_ranking
    ADD CONSTRAINT item_ranking_pkey PRIMARY KEY (scat_cd, rank);


--
-- Name: item_sale item_sale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_sale
    ADD CONSTRAINT item_sale_pkey PRIMARY KEY (item_id);


--
-- Name: item_scat item_scat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_scat
    ADD CONSTRAINT item_scat_pkey PRIMARY KEY (scat_id);


--
-- Name: item_set item_set_item_set_key_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_set
    ADD CONSTRAINT item_set_item_set_key_key UNIQUE (item_set_key);


--
-- Name: item_set_main item_set_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_set_main
    ADD CONSTRAINT item_set_main_pkey PRIMARY KEY (item_set_main_id);


--
-- Name: item_set item_set_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_set
    ADD CONSTRAINT item_set_pkey PRIMARY KEY (item_set_id);


--
-- Name: item_set_sub item_set_sub_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_set_sub
    ADD CONSTRAINT item_set_sub_pkey PRIMARY KEY (item_set_sub_id);


--
-- Name: item_site item_site_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_site
    ADD CONSTRAINT item_site_pkey PRIMARY KEY (item_site_id);


--
-- Name: item_type_master item_type_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.item_type_master
    ADD CONSTRAINT item_type_master_pkey PRIMARY KEY (item_type);


--
-- Name: kessai_method_tb kessai_method_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.kessai_method_tb
    ADD CONSTRAINT kessai_method_tb_pkey PRIMARY KEY (method_id);


--
-- Name: leadtime leadtime_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leadtime
    ADD CONSTRAINT leadtime_pkey PRIMARY KEY (leadtime);


--
-- Name: log_info log_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_info
    ADD CONSTRAINT log_info_pkey PRIMARY KEY (log_id, display_id);


--
-- Name: mail_sub mail_sub_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mail_sub
    ADD CONSTRAINT mail_sub_pkey PRIMARY KEY (mail_sub_id);


--
-- Name: manage_tb_note manage_tb_note_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manage_tb_note
    ADD CONSTRAINT manage_tb_note_pkey PRIMARY KEY (coid);


--
-- Name: menu_tb menu_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menu_tb
    ADD CONSTRAINT menu_tb_pkey PRIMARY KEY (coid);


--
-- Name: notice_tb notice_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notice_tb
    ADD CONSTRAINT notice_tb_pkey PRIMARY KEY (notice_id);


--
-- Name: ntt_flg_tb ntt_flg_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ntt_flg_tb
    ADD CONSTRAINT ntt_flg_tb_pkey PRIMARY KEY (ordercd);


--
-- Name: ntt_tsuban_tb ntt_tsuban_tb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ntt_tsuban_tb
    ADD CONSTRAINT ntt_tsuban_tb_pkey PRIMARY KEY (id);


--
-- Name: oem_custom_bun oem_custom_bun_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oem_custom_bun
    ADD CONSTRAINT oem_custom_bun_pkey PRIMARY KEY (buncd);


--
-- Name: oem_fromname oem_fromname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oem_fromname
    ADD CONSTRAINT oem_fromname_pkey PRIMARY KEY (fromcd);


--
-- Name: oem_order oem_order_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oem_order
    ADD CONSTRAINT oem_order_pkey PRIMARY KEY (ordercd);


--
-- Name: oem_quest oem_quest_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oem_quest
    ADD CONSTRAINT oem_quest_pkey PRIMARY KEY (q_cd);


--
-- Name: oem_user oem_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oem_user
    ADD CONSTRAINT oem_user_pkey PRIMARY KEY (oem_login_no);


--
-- Name: order_barcode_bak order_barcode_bak_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_barcode_bak
    ADD CONSTRAINT order_barcode_bak_pkey PRIMARY KEY (bak_id);


--
-- Name: order_barcode_fix_mng order_barcode_fix_mng_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_barcode_fix_mng
    ADD CONSTRAINT order_barcode_fix_mng_pkey PRIMARY KEY (depocd, year, mon, depocd_act);


--
-- Name: order_barcode_fix order_barcode_fix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_barcode_fix
    ADD CONSTRAINT order_barcode_fix_pkey PRIMARY KEY (depocd, year, mon, type);


--
-- Name: order_barcode order_barcode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_barcode
    ADD CONSTRAINT order_barcode_pkey PRIMARY KEY (ordercd);


--
-- Name: order_etc_data order_etc_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_etc_data
    ADD CONSTRAINT order_etc_data_pkey PRIMARY KEY (ordercd);


--
-- Name: order_template order_template_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_template
    ADD CONSTRAINT order_template_pkey PRIMARY KEY (tempcd);


--
-- Name: ordercd_barcode_link ordercd_barcode_link_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ordercd_barcode_link
    ADD CONSTRAINT ordercd_barcode_link_pkey PRIMARY KEY (ordercd, sub_quest_cscd);


--
-- Name: past_company_general_account past_company_general_account_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_company_general_account
    ADD CONSTRAINT past_company_general_account_pkey PRIMARY KEY (coid, bank_account_id);


--
-- Name: past_company_opt past_company_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_company_opt
    ADD CONSTRAINT past_company_opt_pkey PRIMARY KEY (coid);


--
-- Name: price_plan_company price_plan_company_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_plan_company
    ADD CONSTRAINT price_plan_company_pkey PRIMARY KEY (coid, price_plan_master_id);


--
-- Name: price_plan_item price_plan_item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_plan_item
    ADD CONSTRAINT price_plan_item_pkey PRIMARY KEY (price_plan_master_id, item_cd);


--
-- Name: price_plan_master price_plan_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_plan_master
    ADD CONSTRAINT price_plan_master_pkey PRIMARY KEY (price_plan_master_id);


--
-- Name: q_history_lcat q_history_lcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.q_history_lcat
    ADD CONSTRAINT q_history_lcat_pkey PRIMARY KEY (q_lcat_id);


--
-- Name: q_history_mcat q_history_mcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.q_history_mcat
    ADD CONSTRAINT q_history_mcat_pkey PRIMARY KEY (q_mcat_id);


--
-- Name: q_history_scat q_history_scat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.q_history_scat
    ADD CONSTRAINT q_history_scat_pkey PRIMARY KEY (q_scat_id);


--
-- Name: quest quest_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quest
    ADD CONSTRAINT quest_pkey PRIMARY KEY (q_cd);


--
-- Name: review review_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.review
    ADD CONSTRAINT review_pkey PRIMARY KEY (cam_num);


--
-- Name: rireki rireki_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rireki
    ADD CONSTRAINT rireki_pkey PRIMARY KEY (r_cd);


--
-- Name: s_alert s_alert_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_alert
    ADD CONSTRAINT s_alert_pkey PRIMARY KEY (alert_id);


--
-- Name: s_change_history s_change_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_change_history
    ADD CONSTRAINT s_change_history_pkey PRIMARY KEY (change_id);


--
-- Name: s_dead_stock_composition_results s_dead_stock_composition_results_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_dead_stock_composition_results
    ADD CONSTRAINT s_dead_stock_composition_results_pkey PRIMARY KEY (dead_stock_results_id);


--
-- Name: s_dead_stock_results s_dead_stock_results_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_dead_stock_results
    ADD CONSTRAINT s_dead_stock_results_pkey PRIMARY KEY (dead_stock_results_id);


--
-- Name: s_delivery_results s_delivery_results_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_delivery_results
    ADD CONSTRAINT s_delivery_results_pkey PRIMARY KEY (delivery_results_id);


--
-- Name: s_depo_change_history s_depo_change_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_depo_change_history
    ADD CONSTRAINT s_depo_change_history_pkey PRIMARY KEY (id);


--
-- Name: s_depo_transports_composition_detail s_depo_transports_composition_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_depo_transports_composition_detail
    ADD CONSTRAINT s_depo_transports_composition_detail_pkey PRIMARY KEY (transports_composition_detail_id);


--
-- Name: s_depo_transports_detail s_depo_transports_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_depo_transports_detail
    ADD CONSTRAINT s_depo_transports_detail_pkey PRIMARY KEY (depo_transports_detail_id);


--
-- Name: s_depo_transports s_depo_transports_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_depo_transports
    ADD CONSTRAINT s_depo_transports_pkey PRIMARY KEY (depo_transports_id);


--
-- Name: s_district s_district_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_district
    ADD CONSTRAINT s_district_pkey PRIMARY KEY (district_id);


--
-- Name: s_item_composition_master s_item_composition_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_item_composition_master
    ADD CONSTRAINT s_item_composition_master_pkey PRIMARY KEY (item_composition_master_id);


--
-- Name: s_item_composition_stock s_item_composition_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_item_composition_stock
    ADD CONSTRAINT s_item_composition_stock_pkey PRIMARY KEY (item_composition_stock_id);


--
-- Name: s_message_group_mst s_message_group_mst_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_message_group_mst
    ADD CONSTRAINT s_message_group_mst_pkey PRIMARY KEY (message_group_id);


--
-- Name: s_monthly_report_composition_detail s_monthly_report_composition_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_monthly_report_composition_detail
    ADD CONSTRAINT s_monthly_report_composition_detail_pkey PRIMARY KEY (report_composition_detail_id);


--
-- Name: s_monthly_report_detail s_monthly_report_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_monthly_report_detail
    ADD CONSTRAINT s_monthly_report_detail_pkey PRIMARY KEY (report_detail_id);


--
-- Name: s_monthly_report s_monthly_report_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_monthly_report
    ADD CONSTRAINT s_monthly_report_pkey PRIMARY KEY (report_id);


--
-- Name: s_pref s_pref_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_pref
    ADD CONSTRAINT s_pref_pkey PRIMARY KEY (pref_id);


--
-- Name: s_proper_stock s_proper_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_proper_stock
    ADD CONSTRAINT s_proper_stock_pkey PRIMARY KEY (proper_stock_id);


--
-- Name: s_shipment_composition_stock s_shipment_composition_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipment_composition_stock
    ADD CONSTRAINT s_shipment_composition_stock_pkey PRIMARY KEY (shipment_composition_stock_id);


--
-- Name: s_shipment_stock s_shipment_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipment_stock
    ADD CONSTRAINT s_shipment_stock_pkey PRIMARY KEY (shipment_stock_id);


--
-- Name: s_shipping_composition_detail s_shipping_composition_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipping_composition_detail
    ADD CONSTRAINT s_shipping_composition_detail_pkey PRIMARY KEY (shipping_composition_detail_id);


--
-- Name: s_shipping_detail s_shipping_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipping_detail
    ADD CONSTRAINT s_shipping_detail_pkey PRIMARY KEY (shipping_detail_id);


--
-- Name: s_shipping_group_master s_shipping_group_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipping_group_master
    ADD CONSTRAINT s_shipping_group_master_pkey PRIMARY KEY (group_id);


--
-- Name: s_shipping_message s_shipping_message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipping_message
    ADD CONSTRAINT s_shipping_message_pkey PRIMARY KEY (shipping_message_id);


--
-- Name: s_shipping s_shipping_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_shipping
    ADD CONSTRAINT s_shipping_pkey PRIMARY KEY (shipping_id);


--
-- Name: s_stock_history s_stock_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_stock_history
    ADD CONSTRAINT s_stock_history_pkey PRIMARY KEY (hist_id);


--
-- Name: s_stock s_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_stock
    ADD CONSTRAINT s_stock_pkey PRIMARY KEY (stock_id);


--
-- Name: s_threshold s_threshold_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_threshold
    ADD CONSTRAINT s_threshold_pkey PRIMARY KEY (threshold_id);


--
-- Name: s_threshold_range_master s_threshold_range_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_threshold_range_master
    ADD CONSTRAINT s_threshold_range_master_pkey PRIMARY KEY (threshold_range_id);


--
-- Name: s_to_depo_message s_to_depo_message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.s_to_depo_message
    ADD CONSTRAINT s_to_depo_message_pkey PRIMARY KEY (message_id);


--
-- Name: settle_depart_remark settle_depart_remark_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settle_depart_remark
    ADD CONSTRAINT settle_depart_remark_pkey PRIMARY KEY (s_cd, branch_number);


--
-- Name: settle_res_corp settle_res_corp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settle_res_corp
    ADD CONSTRAINT settle_res_corp_pkey PRIMARY KEY (s_cd, branch_number);


--
-- Name: sub_barcode_fix_master sub_barcode_fix_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_barcode_fix_master
    ADD CONSTRAINT sub_barcode_fix_master_pkey PRIMARY KEY (sub_barcode_fix_master_id);


--
-- Name: sub_barcode_fix sub_barcode_fix_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_barcode_fix
    ADD CONSTRAINT sub_barcode_fix_pkey PRIMARY KEY (sub_barcode_fix_id);


--
-- Name: sub_barcode sub_barcode_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_barcode
    ADD CONSTRAINT sub_barcode_pkey PRIMARY KEY (sub_barcode_id);


--
-- Name: sub_company_master sub_company_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_company_master
    ADD CONSTRAINT sub_company_master_pkey PRIMARY KEY (sub_company_cd);


--
-- Name: summary_save summary_save_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.summary_save
    ADD CONSTRAINT summary_save_pkey PRIMARY KEY (summary_save_id);


--
-- Name: telephone_denial_company telephone_denial_company_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telephone_denial_company
    ADD CONSTRAINT telephone_denial_company_pkey PRIMARY KEY (coid);


--
-- Name: undeliv_area undeliv_area_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.undeliv_area
    ADD CONSTRAINT undeliv_area_pkey PRIMARY KEY (undeliv_addr_id);


--
-- Name: undeliv_item_opt undeliv_item_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.undeliv_item_opt
    ADD CONSTRAINT undeliv_item_opt_pkey PRIMARY KEY (undeliv_id);


--
-- Name: undeliv_opt undeliv_opt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.undeliv_opt
    ADD CONSTRAINT undeliv_opt_pkey PRIMARY KEY (undeliv_id);


--
-- Name: user_auth_status user_auth_status_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_auth_status
    ADD CONSTRAINT user_auth_status_pkey PRIMARY KEY (user_id);


--
-- Name: user_auth_stg user_auth_stg_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_auth_stg
    ADD CONSTRAINT user_auth_stg_pkey PRIMARY KEY (name);


--
-- Name: zeus_etc_data zeus_etc_data_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.zeus_etc_data
    ADD CONSTRAINT zeus_etc_data_pkey PRIMARY KEY (zeuscd);


--
-- Name: ac_org_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ac_org_idx ON public.member_acs USING btree (org_id);


--
-- Name: acc_cid_070302_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX acc_cid_070302_idx ON public.account_id USING btree (coid);


--
-- Name: addrcd_2019113018_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX addrcd_2019113018_idx ON public.address USING btree (addrcd);


--
-- Name: ast_scd_061023_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX ast_scd_061023_idx ON public.ast_s USING btree (syo_cd);


--
-- Name: ast_ycd_061023_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX ast_ycd_061023_idx ON public.ast_y USING btree (yos_cd);


--
-- Name: b_ordercd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX b_ordercd_idx ON public.b_order_master USING btree (b_ordercd);


--
-- Name: b_ordernum_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX b_ordernum_idx ON public.b_order_item USING btree (b_ordercd, b_ordernum);


--
-- Name: bank_account_disp_turn_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bank_account_disp_turn_idx ON public.bank_account USING btree (disp_turn);


--
-- Name: bank_bankkana_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bank_bankkana_idx ON public.bank_master USING btree (bank_kana);


--
-- Name: bank_banknm_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bank_banknm_idx ON public.bank_master USING btree (bank_nm);


--
-- Name: bank_branchkana_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bank_branchkana_idx ON public.bank_master USING btree (branch_kana);


--
-- Name: bank_branchnm_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bank_branchnm_idx ON public.bank_master USING btree (branch_nm);


--
-- Name: bcpm_coid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX bcpm_coid_idx ON public.bill_category_plan_master USING btree (coid);


--
-- Name: benri_nouhin_n_cd_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX benri_nouhin_n_cd_key ON public.benri_nouhin USING btree (n_cd);


--
-- Name: bk_agid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX bk_agid_idx ON public.bk_name USING btree (coid);


--
-- Name: bkcd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX bkcd_idx ON public.bk_name USING btree (bkcd);


--
-- Name: btov_if_benri_id_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX btov_if_benri_id_key ON public.btov_if USING btree (benri_id);


--
-- Name: campaign_cam_num_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX campaign_cam_num_idx ON public.campaign USING btree (cam_num);


--
-- Name: campaign_list_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX campaign_list_idx ON public.campaign_list USING btree (e_date);


--
-- Name: campaign_ordercd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX campaign_ordercd_idx ON public.campaign USING btree (ordercd);


--
-- Name: cart_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cart_cd_idx ON public.cart USING btree (cartcd);


--
-- Name: cbun_ucd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cbun_ucd_idx ON public.custom_bun USING btree (usercd);


--
-- Name: cbuncd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cbuncd_idx ON public.custom_bun USING btree (buncd);


--
-- Name: cc_tmp_ccnum_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX cc_tmp_ccnum_key ON public.cc_tmp USING btree (ccnum);


--
-- Name: cmas_aid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cmas_aid_idx ON public.c_master USING btree (ag_1, ag_2, ag_3);


--
-- Name: cmas_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX cmas_cid_idx ON public.c_master USING btree (coid);


--
-- Name: cmas_cname_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cmas_cname_idx ON public.c_master USING btree (c_name);


--
-- Name: coidlist_coid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX coidlist_coid_idx ON public.coidlist USING btree (coid);


--
-- Name: column_data_file_name_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX column_data_file_name_idx ON public.column_data USING btree (column_category_id, file_name);


--
-- Name: cs_tmpl_cond_idx1; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cs_tmpl_cond_idx1 ON public.cs_template_cond USING btree (cond_id);


--
-- Name: cs_tmpl_cond_idx2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX cs_tmpl_cond_idx2 ON public.cs_template_cond USING btree (site, channel_cd1, channel_cd2, q_lcat_cd, q_mcat_cd, q_scat_cd);


--
-- Name: cs_tmpl_cond_link_idx2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cs_tmpl_cond_link_idx2 ON public.cs_template_cond_link USING btree (tmpl_id);


--
-- Name: cs_tmpl_cond_link_idx3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cs_tmpl_cond_link_idx3 ON public.cs_template_cond_link USING btree (cond_id);


--
-- Name: cs_tmpl_master_idx1; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cs_tmpl_master_idx1 ON public.cs_template_master USING btree (tmpl_id);


--
-- Name: cs_tmpl_master_idx2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cs_tmpl_master_idx2 ON public.cs_template_master USING btree (tmpl_no);


--
-- Name: d_code_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX d_code_idx ON public.h_dep USING btree (d_code);


--
-- Name: del_ag_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX del_ag_idx ON public.del_order USING btree (ag_1, ag_2, ag_3);


--
-- Name: del_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX del_cid_idx ON public.del_order USING btree (coid);


--
-- Name: es_nid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX es_nid_idx ON public.es_pay USING btree (noah_id, d_type);


--
-- Name: faq_fnum_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX faq_fnum_key ON public.faq USING btree (fnum);


--
-- Name: from_ucd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX from_ucd_idx ON public.fromname USING btree (usercd);


--
-- Name: gp_err_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX gp_err_idx ON public.gp_err USING btree (errinfo, errcode);


--
-- Name: h_rocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX h_rocd_idx ON public.h_order_master USING btree (r_ordercd);


--
-- Name: hikiotoshi_qcode_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX hikiotoshi_qcode_idx ON public.hikiotoshi USING btree (q_code);


--
-- Name: income_cedyna_incd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX income_cedyna_incd_idx ON public.income_cedyna USING btree (in_cd);


--
-- Name: income_cedyna_scd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX income_cedyna_scd_idx ON public.income_cedyna USING btree (s_cd);


--
-- Name: income_incd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX income_incd_idx ON public.income USING btree (in_cd);


--
-- Name: income_scd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX income_scd_idx ON public.income USING btree (s_cd);


--
-- Name: income_vone_seqno_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX income_vone_seqno_idx ON public.income USING btree (vone_invoice_seqno, vone_payment_seqno);


--
-- Name: ishop_rocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ishop_rocd_idx ON public.ishop_omas USING btree (r_ordercd);


--
-- Name: item_addition_choice_link_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_addition_choice_link_item_cd_idx ON public.item_addition_choice_link USING btree (item_cd);


--
-- Name: item_addition_choice_link_sale_site_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_addition_choice_link_sale_site_item_cd_idx ON public.item_addition_choice_link USING btree (sale_site, item_cd);


--
-- Name: item_group_choice_link_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_group_choice_link_item_cd_idx ON public.item_group_choice_link USING btree (item_cd);


--
-- Name: item_set_sub_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_set_sub_item_cd_idx ON public.item_set_sub USING btree (item_cd);


--
-- Name: item_set_sub_sale_site_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_set_sub_sale_site_item_cd_idx ON public.item_set_sub USING btree (sale_site, item_cd);


--
-- Name: item_set_sub_sale_site_item_set_main_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_set_sub_sale_site_item_set_main_id_idx ON public.item_set_sub USING btree (sale_site, item_set_main_id);


--
-- Name: item_site_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_site_item_cd_idx ON public.item_site USING btree (item_cd);


--
-- Name: item_site_sale_site_item_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX item_site_sale_site_item_cd_idx ON public.item_site USING btree (sale_site, item_cd);


--
-- Name: jp_rocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jp_rocd_idx ON public.jp_omas USING btree (r_ordercd);


--
-- Name: jp_test_rocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jp_test_rocd_idx ON public.jp_omas_test USING btree (r_ordercd);


--
-- Name: k_gcd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX k_gcd_idx ON public.k_gyousya USING btree (g_cd);


--
-- Name: k_himoku_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX k_himoku_idx ON public.k_himoku USING btree (himoku_cd);


--
-- Name: k_siire_didx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX k_siire_didx ON public.k_siire_d USING btree (siire_cd, siire_num);


--
-- Name: k_siire_midx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX k_siire_midx ON public.k_siire_m USING btree (siire_cd);


--
-- Name: k_siwake_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX k_siwake_idx ON public.k_siwake USING btree (siwake_cd);


--
-- Name: kms_sch_mem_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX kms_sch_mem_idx ON public.kms_schedule USING btree (member_id);


--
-- Name: kms_schid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX kms_schid_idx ON public.kms_schedule USING btree (sch_id);


--
-- Name: logi_log_num_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX logi_log_num_key ON public.logi_log USING btree (num);


--
-- Name: m_acs_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX m_acs_idx ON public.member_acs USING btree (acs_cd);


--
-- Name: mes_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX mes_ocd_idx ON public.message USING btree (ordercd);


--
-- Name: mes_zcd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX mes_zcd_idx ON public.message USING btree (zeuscd);


--
-- Name: mew_incd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX mew_incd_idx ON public.mew_in USING btree (in_cd);


--
-- Name: od_old_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX od_old_ocd_idx ON public.order_data_old USING btree (ordercd);


--
-- Name: odat_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX odat_ocd_idx ON public.order_data USING btree (ordercd);


--
-- Name: oem_custom_bun_oem_login_no_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oem_custom_bun_oem_login_no_idx ON public.oem_custom_bun USING btree (oem_login_no);


--
-- Name: oem_fromname_oem_login_no_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oem_fromname_oem_login_no_idx ON public.oem_fromname USING btree (oem_login_no);


--
-- Name: oem_quest_q_oem_login_no_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oem_quest_q_oem_login_no_idx ON public.oem_quest USING btree (q_oem_login_no);


--
-- Name: oem_user_user_no_cust_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX oem_user_user_no_cust_cd_idx ON public.oem_user USING btree (user_no, cust_cd);


--
-- Name: omas_aid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_aid_idx ON public.order_master USING btree (ag_1, ag_2, ag_3);


--
-- Name: omas_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_cid_idx ON public.order_master USING btree (coid);


--
-- Name: omas_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_ocd_idx ON public.order_master USING btree (ordercd);


--
-- Name: omas_old_adate_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_old_adate_idx ON public.order_master_old USING btree (a_date);


--
-- Name: omas_old_aid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_old_aid_idx ON public.order_master_old USING btree (ag_1, ag_2, ag_3);


--
-- Name: omas_old_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_old_cid_idx ON public.order_master_old USING btree (coid);


--
-- Name: omas_old_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_old_ocd_idx ON public.order_master_old USING btree (ordercd);


--
-- Name: omas_old_odate_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omas_old_odate_idx ON public.order_master_old USING btree (o_date);


--
-- Name: omron_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX omron_cid_idx ON public.omron USING btree (coid);


--
-- Name: opt_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX opt_ocd_idx ON public.opt_order USING btree (ordercd);


--
-- Name: order_adate_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX order_adate_idx ON public.order_master USING btree (a_date);


--
-- Name: order_barcode_bak_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX order_barcode_bak_idx ON public.order_barcode_bak USING btree (ordercd, quest_cscd);


--
-- Name: order_barcode_fix_fix_at_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX order_barcode_fix_fix_at_idx ON public.order_barcode_fix USING btree (fix_at);


--
-- Name: order_barcode_fix_mng_fix_at_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX order_barcode_fix_mng_fix_at_idx ON public.order_barcode_fix_mng USING btree (fix_at);


--
-- Name: order_barcode_quest_cscd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX order_barcode_quest_cscd_idx ON public.order_barcode USING btree (quest_cscd);


--
-- Name: ordercd_barcode_link_b_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ordercd_barcode_link_b_idx ON public.ordercd_barcode_link USING btree (sub_quest_cscd);


--
-- Name: ordercd_barcode_link_o_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ordercd_barcode_link_o_idx ON public.ordercd_barcode_link USING btree (ordercd);


--
-- Name: ppm_scat_dsp_turn_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ppm_scat_dsp_turn_idx ON public.price_plan_master USING btree (scat_cd, dsp_turn);


--
-- Name: ppm_scat_price_plan_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX ppm_scat_price_plan_idx ON public.price_plan_master USING btree (scat_cd, price_plan_id);


--
-- Name: prefsiku_2019113018_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX prefsiku_2019113018_idx ON public.address USING btree (pref, siku);


--
-- Name: q_history_date_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX q_history_date_idx ON public.q_history USING btree (q_date);


--
-- Name: q_history_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX q_history_ocd_idx ON public.q_history USING btree (ordercd);


--
-- Name: q_history_q_cd_key; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX q_history_q_cd_key ON public.q_history USING btree (q_cd);


--
-- Name: qlcat_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX qlcat_cd_idx ON public.q_history_lcat USING btree (q_lcat_cd);


--
-- Name: qmcat_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX qmcat_cd_idx ON public.q_history_mcat USING btree (q_lcat_cd, q_mcat_cd);


--
-- Name: qscat_cd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX qscat_cd_idx ON public.q_history_scat USING btree (q_lcat_cd, q_mcat_cd, q_scat_cd);


--
-- Name: s_delivery_results_stock_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_delivery_results_stock_id_idx ON public.s_delivery_results USING btree (stock_id);


--
-- Name: s_delivery_results_years_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_delivery_results_years_idx ON public.s_delivery_results USING btree (delivery_results_years);


--
-- Name: s_monthly_report_detail_report_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_monthly_report_detail_report_id_idx ON public.s_monthly_report_detail USING btree (report_id);


--
-- Name: s_proper_stock_object_years_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_proper_stock_object_years_idx ON public.s_proper_stock USING btree (object_years);


--
-- Name: s_proper_stock_stock_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_proper_stock_stock_id_idx ON public.s_proper_stock USING btree (stock_id);


--
-- Name: s_shipping_composition_detail_shipping_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_shipping_composition_detail_shipping_id_idx ON public.s_shipping_composition_detail USING btree (shipping_id);


--
-- Name: s_shipping_detail_shipping_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_shipping_detail_shipping_id_idx ON public.s_shipping_detail USING btree (shipping_id);


--
-- Name: s_stock_depocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX s_stock_depocd_idx ON public.s_stock USING btree (depocd);


--
-- Name: sbfm_depocd_year_mon_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX sbfm_depocd_year_mon_idx ON public.sub_barcode_fix_master USING btree (depocd, year, mon);


--
-- Name: sdat_scd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sdat_scd_idx ON public.seikyuu_data USING btree (s_cd);


--
-- Name: smas_2006_did_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX smas_2006_did_idx ON public.seikyuu_master USING btree (d_coid);


--
-- Name: smas_2006_scd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX smas_2006_scd_idx ON public.seikyuu_master USING btree (s_cd);


--
-- Name: smas_2006_sid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX smas_2006_sid_idx ON public.seikyuu_master USING btree (s_coid);


--
-- Name: smas_custom_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX smas_custom_idx ON public.seikyuu_master USING btree (custom_key);


--
-- Name: ss_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX ss_ocd_idx ON public.sinwa_sendto USING btree (ordercd, ordernum);


--
-- Name: stock_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX stock_idx ON public.s_stock USING btree (item_id, depocd);


--
-- Name: sub_barcode_fix_master_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sub_barcode_fix_master_id_idx ON public.sub_barcode_fix USING btree (sub_barcode_fix_master_id);


--
-- Name: sub_barcode_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sub_barcode_id_idx ON public.order_barcode USING btree (sub_barcode_id);


--
-- Name: sub_quest_cscd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sub_quest_cscd_idx ON public.sub_barcode USING btree (sub_quest_cscd);


--
-- Name: sys_snum_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX sys_snum_idx ON public.sys_order USING btree (s_num);


--
-- Name: u_num_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX u_num_idx ON public.unchin USING btree (u_num);


--
-- Name: user_cid_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX user_cid_idx ON public.usercd USING btree (coid);


--
-- Name: user_ucd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX user_ucd_idx ON public.usercd USING btree (usercd);


--
-- Name: vc_depo_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX vc_depo_idx ON public.vc_order USING btree (depocd);


--
-- Name: vc_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX vc_ocd_idx ON public.vc_order USING btree (ordercd);


--
-- Name: vc_old_ck_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX vc_old_ck_idx ON public.vc_order_old USING btree (ck_order);


--
-- Name: vc_old_ocd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX vc_old_ocd_idx ON public.vc_order_old USING btree (ordercd);


--
-- Name: zeuscd_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX zeuscd_idx ON public.zeus USING btree (zeuscd);


--
-- Name: cs_template_cond_link cs_template_cond_link_cond_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_cond_link
    ADD CONSTRAINT cs_template_cond_link_cond_id_fkey FOREIGN KEY (cond_id) REFERENCES public.cs_template_cond(cond_id);


--
-- Name: cs_template_cond_link cs_template_cond_link_tmpl_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cs_template_cond_link
    ADD CONSTRAINT cs_template_cond_link_tmpl_id_fkey FOREIGN KEY (tmpl_id) REFERENCES public.cs_template_master(tmpl_id);


--
-- Name: TABLE cc_tmp; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.cc_tmp TO PUBLIC;


--
-- Name: TABLE ctalk_voice; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.ctalk_voice TO PUBLIC;


--
-- Name: TABLE gmo_res; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.gmo_res TO PUBLIC;


--
-- Name: SEQUENCE k_user_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.k_user_seq TO PUBLIC;


--
-- Name: TABLE ls_acs; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.ls_acs TO PUBLIC;


--
-- Name: TABLE ls_order; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.ls_order TO PUBLIC;


--
-- Name: TABLE voice; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.voice TO PUBLIC;


--
-- PostgreSQL database dump complete
--

