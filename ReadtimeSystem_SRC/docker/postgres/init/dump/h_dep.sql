--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Data for Name: h_dep; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY h_dep (d_code, d_name, g_code, g_name) FROM stdin;
1	営業部	0	部付
9	その他	2	ＢＷ
9	その他	1	ＦＣ
9	その他	99	その他
8	東京その他	0	スペース
8	東京その他	1	東京その他
6	事業推進部	0	部付
7	大阪その他	0	スペース
7	大阪その他	1	大阪その他
9	その他	3	センコー
1	営業部	1	法人営業課
4	管理部	0	部付
4	管理部	1	経理課
4	管理部	2	総務課
6	事業推進部	3	物流課
2	経営企画部	0	部付
2	経営企画部	1	企画室
3	システム・マーケティング部	0	部付
4	管理部	0	部付
4	管理部	1	経理課
4	管理部	2	総務課
6	事業推進部	2	CS推進課
6	事業推進部	3	物流課
1	営業部	2	商品企画課
3	システム・マーケティング部	3	マーケティング課
3	システム・マーケティング部	1	システム課
1	営業部	3	フラワー・ギフト課
\.


--
-- PostgreSQL database dump complete
--

