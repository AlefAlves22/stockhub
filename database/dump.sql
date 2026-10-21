--
-- PostgreSQL database dump
--

\restrict FoDSLla27acvTnsr4JFf7iBtXUVOd2dde6r1wmIfjP0nipsjkhTHDCggqh85Fsq

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cliente; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.cliente (
    id integer NOT NULL,
    nome_cliente character varying(255) NOT NULL,
    cpf character varying(14) NOT NULL,
    telefone character varying(20) NOT NULL,
    endereco character varying(255) NOT NULL
);


ALTER TABLE public.cliente OWNER TO estoquista;

--
-- Name: cliente_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.cliente_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cliente_id_seq OWNER TO estoquista;

--
-- Name: cliente_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.cliente_id_seq OWNED BY public.cliente.id;


--
-- Name: estoque; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.estoque (
    id integer NOT NULL,
    quantidade_estoque integer,
    fornecedor character varying(150),
    sku character varying(50),
    codigo_barra character varying(13)
);


ALTER TABLE public.estoque OWNER TO estoquista;

--
-- Name: estoque_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.estoque_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.estoque_id_seq OWNER TO estoquista;

--
-- Name: estoque_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.estoque_id_seq OWNED BY public.estoque.id;


--
-- Name: login; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.login (
    id integer NOT NULL,
    nome character varying(200),
    email character varying(255),
    cpf character varying(14),
    senha character varying(255)
);


ALTER TABLE public.login OWNER TO estoquista;

--
-- Name: login_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.login_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.login_id_seq OWNER TO estoquista;

--
-- Name: login_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.login_id_seq OWNED BY public.login.id;


--
-- Name: produtos; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.produtos (
    id integer NOT NULL,
    sku character varying(50) NOT NULL,
    nome_produto character varying(200) NOT NULL,
    valor_final numeric(10,2) NOT NULL,
    valor_entrada numeric(10,2) NOT NULL,
    descricao text,
    codigo_barra character varying(13)
);


ALTER TABLE public.produtos OWNER TO estoquista;

--
-- Name: produtos_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produtos_id_seq OWNER TO estoquista;

--
-- Name: produtos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.produtos_id_seq OWNED BY public.produtos.id;


--
-- Name: vendas; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.vendas (
    id integer NOT NULL,
    nome_cliente character varying(100) CONSTRAINT vendas_id_cliente_not_null NOT NULL,
    nome_vendedor character varying(100) CONSTRAINT vendas_id_vendedor_not_null NOT NULL,
    nome_produtos character varying(100) CONSTRAINT vendas_id_produtos_not_null NOT NULL,
    quantidade integer NOT NULL,
    data_venda timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.vendas OWNER TO estoquista;

--
-- Name: vendas_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.vendas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vendas_id_seq OWNER TO estoquista;

--
-- Name: vendas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.vendas_id_seq OWNED BY public.vendas.id;


--
-- Name: vendedor; Type: TABLE; Schema: public; Owner: estoquista
--

CREATE TABLE public.vendedor (
    id integer NOT NULL,
    nome_vendedor character varying(255) NOT NULL,
    cpf character varying(14) NOT NULL
);


ALTER TABLE public.vendedor OWNER TO estoquista;

--
-- Name: vendedor_id_seq; Type: SEQUENCE; Schema: public; Owner: estoquista
--

CREATE SEQUENCE public.vendedor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vendedor_id_seq OWNER TO estoquista;

--
-- Name: vendedor_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: estoquista
--

ALTER SEQUENCE public.vendedor_id_seq OWNED BY public.vendedor.id;


--
-- Name: cliente id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.cliente ALTER COLUMN id SET DEFAULT nextval('public.cliente_id_seq'::regclass);


--
-- Name: estoque id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.estoque ALTER COLUMN id SET DEFAULT nextval('public.estoque_id_seq'::regclass);


--
-- Name: login id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.login ALTER COLUMN id SET DEFAULT nextval('public.login_id_seq'::regclass);


--
-- Name: produtos id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.produtos ALTER COLUMN id SET DEFAULT nextval('public.produtos_id_seq'::regclass);


--
-- Name: vendas id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.vendas ALTER COLUMN id SET DEFAULT nextval('public.vendas_id_seq'::regclass);


--
-- Name: vendedor id; Type: DEFAULT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.vendedor ALTER COLUMN id SET DEFAULT nextval('public.vendedor_id_seq'::regclass);


--
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.cliente (id, nome_cliente, cpf, telefone, endereco) FROM stdin;
7	Giovanna Sangalli	337.000.000-12	19888888888	Mac donalds
\.


--
-- Data for Name: estoque; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.estoque (id, quantidade_estoque, fornecedor, sku, codigo_barra) FROM stdin;
1	99	Jorge carneiro informática	\N	\N
2	\N	\N	\N	\N
3	3	BLA	\N	\N
10	56	Pisokoll	9085-1	7891200028085
12	50	BIC	176072 	70330129627
13	11	Hidroall	1238 	7896693812388
9	11	Pisokoll	PROD_43080	7891100011163
\.


--
-- Data for Name: login; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.login (id, nome, email, cpf, senha) FROM stdin;
1	Alef	alef@gmail	000.000.000-00	1234
2	alef	alef.a@edu.senai.br	1234567890123	12345
3	Vitoria	vitoria@gmail	1234567890123	vitoria
4	Alef	alef.a@edu.senai.br	51892697874	devtec2026
\.


--
-- Data for Name: produtos; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.produtos (id, sku, nome_produto, valor_final, valor_entrada, descricao, codigo_barra) FROM stdin;
6	CI-02	Cimento CP-2 Caue	43.90	35.90	Cimeno usado para grandes construções	\N
7	AR-03	Argamassa ac3 pisokoll	29.90	15.90	Assentamento de pisos	\N
12	0103	Tubo esgoto 100mm 6m Krona	99.99	75.99	• Instalações prediais de esgoto e ventilação (escoamento por gravidade sem pressão interna)	\N
15	0024 	Tubo soldavel 25mm 6m Krona	79.90	49.99	indicada para conduzir água fria em projetos residenciais, comerciais ou industriais	\N
16	12	teste	13.00	4.00	teste teste	\N
22	15	teste	0.00	0.00	teste teste	\N
28	340523006002	Barrilha 2kg Hidroall	29.90	19.90	 Elevar e normalizar o pH da água de piscinas quando estiver abaixo do ideal (7,2 a 7,6)	7898113910070
29	11671	joelho soldavel 25mm amanco	2.50	0.99	Sistemas prediais de água fria (condução permanente, embutida ou aparente em locais cobertos)	7891960121422
31	345	teste	23.00	34.00	teste teste	1234
33	67	teste	12.00	13.00	12	123
23	23	43	23.00	23.00	23	23
24	teste123	teste teste	123.00	321.00	teste para dar certo	123456789
37	9085-1	Argamassa ac2 pisokoll	24.99	16.99	Argamassa para assentamento de piso interno	7891200028085
36	PROD_43080	Argamassa ac1 pisokoll	19.99	9.99	Usado para assentar piso em áreas secas	7891100011163
39	176072 	Caneta bic azul	2.99	0.99	Caneta para enem	70330129627
40	1238 	O Hidro pH+ (Barrilha Leve) 2Kg da Hidroall	20.00	9.99	Usado para aumentar o ph da agua	7896693812388
\.


--
-- Data for Name: vendas; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.vendas (id, nome_cliente, nome_vendedor, nome_produtos, quantidade, data_venda) FROM stdin;
1	Giovanna Sangalli	Alef	Argamassa ac2 pisokoll	4	2026-10-09 16:28:38.320367
2	Giovanna Sangalli	Alef	Argamassa ac2 pisokoll	4	2026-10-09 16:29:29.012272
3	Jorge	Alef	Argamassa ac1 pisokoll	4	2026-10-09 16:29:57.480819
4	Giovanna Sangalli	Alef	Argamassa ac2 pisokoll	23	2026-10-09 16:33:01.777199
5	Jorge	Alef	Argamassa ac1 pisokoll	5	2026-10-09 16:44:11.408377
6	Giovanna Sangalli	Vitoria	Caneta bic azul	50	2026-10-09 16:54:24.751974
7	Giovanna Sangalli	Alef	O Hidro pH+ (Barrilha Leve) 2Kg da Hidroall	34	2026-10-16 14:36:25.518446
8	Giovanna Sangalli	Alef	Argamassa ac1 pisokoll	4	2026-10-21 08:08:32.684198
\.


--
-- Data for Name: vendedor; Type: TABLE DATA; Schema: public; Owner: estoquista
--

COPY public.vendedor (id, nome_vendedor, cpf) FROM stdin;
1	Alef	1234567890123
\.


--
-- Name: cliente_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.cliente_id_seq', 7, true);


--
-- Name: estoque_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.estoque_id_seq', 13, true);


--
-- Name: login_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.login_id_seq', 4, true);


--
-- Name: produtos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.produtos_id_seq', 40, true);


--
-- Name: vendas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.vendas_id_seq', 8, true);


--
-- Name: vendedor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: estoquista
--

SELECT pg_catalog.setval('public.vendedor_id_seq', 4, true);


--
-- Name: cliente cliente_cpf_key; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_cpf_key UNIQUE (cpf);


--
-- Name: cliente cliente_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT cliente_pkey PRIMARY KEY (id);


--
-- Name: estoque estoque_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_pkey PRIMARY KEY (id);


--
-- Name: login login_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.login
    ADD CONSTRAINT login_pkey PRIMARY KEY (id);


--
-- Name: produtos produtos_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id);


--
-- Name: produtos produtos_sku_key; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_sku_key UNIQUE (sku);


--
-- Name: produtos unique_codigo_barra; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT unique_codigo_barra UNIQUE (codigo_barra);


--
-- Name: vendas vendas_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.vendas
    ADD CONSTRAINT vendas_pkey PRIMARY KEY (id);


--
-- Name: vendedor vendedor_cpf_key; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.vendedor
    ADD CONSTRAINT vendedor_cpf_key UNIQUE (cpf);


--
-- Name: vendedor vendedor_pkey; Type: CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.vendedor
    ADD CONSTRAINT vendedor_pkey PRIMARY KEY (id);


--
-- Name: estoque fk_estoque_produtos_cod_barra; Type: FK CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT fk_estoque_produtos_cod_barra FOREIGN KEY (codigo_barra) REFERENCES public.produtos(codigo_barra) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: estoque fk_estoque_produtos_sku; Type: FK CONSTRAINT; Schema: public; Owner: estoquista
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT fk_estoque_produtos_sku FOREIGN KEY (sku) REFERENCES public.produtos(sku) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: pg_database_owner
--

GRANT ALL ON SCHEMA public TO estoquista;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: postgres
--

ALTER DEFAULT PRIVILEGES FOR ROLE postgres IN SCHEMA public GRANT ALL ON TABLES TO estoquista;


--
-- PostgreSQL database dump complete
--

\unrestrict FoDSLla27acvTnsr4JFf7iBtXUVOd2dde6r1wmIfjP0nipsjkhTHDCggqh85Fsq

