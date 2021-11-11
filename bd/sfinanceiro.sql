  -- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Mar-2019 às 21:01
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfinanceiro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Eduardo Ribeiro', 'augustoeduribeiro@gmail.com', '$2y$10$u4dFvP1cVMgjJcVo8OviS.pSrLi2pyoMA87kElmxNJlH2kpqmZ26G', 'TFhCXRbs3HJ3o7whfTRxBo3Ai3KnMM5BCYDUV28VWj7SMxtGQWI3P9h2zdHz', '2017-04-04 23:12:27', '2017-04-20 23:36:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_banco` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `banks`
--

INSERT INTO `banks` (`id`, `nome`, `codigo_banco`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Banco do Brasil', '01', 'Banco do Brasil S.A', '2017-02-10 15:41:00', '2017-02-10 20:34:38'),
(2, 'Bradesco', '237', 'Bradesco S.a', '2017-02-10 20:51:31', '2017-02-10 20:51:31'),
(3, 'CEF', '104', 'Caixa Econômica Federal', '2017-02-10 20:52:23', '2017-02-10 20:52:23'),
(4, 'Itaú', '184', 'Itaú S.A', '2017-02-14 16:13:19', '2017-02-14 16:13:19'),
(5, 'Hsbc', '399', 'Hsbc S.A', '2017-02-14 16:13:51', '2017-02-14 16:13:51'),
(6, 'SANTANDER', '33', 'SANTANDER S.A', '2017-02-14 16:14:14', '2017-02-14 16:14:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_payments`
--

CREATE TABLE `category_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_cat_pag` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `category_payments`
--

INSERT INTO `category_payments` (`id`, `nome_cat_pag`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Despesas Administrativas', 'Despesas diversos', '2017-07-02 09:00:00', '2017-12-13 15:20:03'),
(3, 'Despesas com pessoal', 'Despesas', '2017-06-20 21:42:36', '2017-12-13 15:27:25'),
(4, 'Despesas Tributária', 'para pagamento de impostos', '2017-08-07 14:42:55', '2017-12-18 14:31:58'),
(5, 'Despesas Financeira', 'Despesas Financeira', '2018-01-10 11:59:39', '2018-01-10 11:59:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_receipts`
--

CREATE TABLE `category_receipts` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_cat_rec` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `category_receipts`
--

INSERT INTO `category_receipts` (`id`, `nome_cat_rec`, `descricao`, `created_at`, `updated_at`) VALUES
(5, 'Receita', 'Tudo que é receita para empresa', '2017-02-15 22:05:14', '2017-12-13 13:29:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uf` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cidades`
--



--
-- Estrutura da tabela `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_empresa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj_cpf` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_fixo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_celular` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uf` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cidade_id` int(10) UNSIGNED DEFAULT NULL,
  `complemento` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bairro` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `companies`
--

INSERT INTO `companies` (`id`, `nome_empresa`, `email`, `cnpj_cpf`, `telefone_fixo`, `telefone_celular`, `endereco`, `cidade`, `uf`, `descricao`, `created_at`, `updated_at`, `cidade_id`, `complemento`, `bairro`, `numero`) VALUES
(1, 'Axia contabilidade', 'contato@axiacontabilidade.com.br', '987653977777', '3136462391', '319866526451', 'Rua: teste', 'BELO HORIZONTE', 'MG', 'Proprietário: Cristiano', '2017-12-04 13:03:37', '2017-12-04 13:03:37', 2754, NULL, 'Barreiro', '987');

-- --------------------------------------------------------

--
-- Estrutura da tabela `creditos`
--

CREATE TABLE `creditos` (
  `id` int(10) UNSIGNED NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `nome_credito` text COLLATE utf8mb4_unicode_ci,
  `data_recebimento` datetime DEFAULT NULL,
  `forma_pagamento_id` int(10) UNSIGNED DEFAULT NULL,
  `receipt_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_id` int(10) UNSIGNED DEFAULT NULL,
  `data_vencimento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `creditos`
--

INSERT INTO `creditos` (`id`, `valor`, `nome_credito`, `data_recebimento`, `forma_pagamento_id`, `receipt_id`, `created_at`, `updated_at`, `bank_id`, `data_vencimento`) VALUES
(2, '904.00', 'comissão de serviço', '2017-12-20 18:28:29', 6, 6, '2017-12-20 20:28:29', '2017-12-20 20:28:29', 6, '2017-12-22 00:00:00'),
(3, '332.00', 'Venda de produto', '2018-01-15 14:44:45', 3, 2, '2018-01-15 16:44:45', '2018-01-15 16:44:45', NULL, '2018-01-20 10:15:25'),
(4, '674.00', 'comissão de serviço extra', '2018-01-17 11:02:17', 1, 5, '2018-01-17 13:02:17', '2018-01-17 13:02:17', NULL, '2018-01-21 13:58:49'),
(5, '765.00', 'Serviços terceiro', '2018-01-17 11:02:27', 1, 8, '2018-01-17 13:02:27', '2018-01-17 13:02:27', NULL, '2018-01-28 14:17:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_cliente` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj_cpf` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_fixo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_celular` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data_vencimento` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`id`, `nome_cliente`, `email`, `cnpj_cpf`, `telefone_fixo`, `telefone_celular`, `status`, `endereco`, `cidade`, `estado`, `descricao`, `created_at`, `updated_at`, `data_vencimento`, `cidade_id`) VALUES
(1, 'Tam arlines', 'tam@mail', '1234567890000', '23232', '3232323', '1', 'Rua: 43 - novo riacho', 'Contagem', 'MG', 'teste', '2017-02-07 04:00:00', '2017-02-07 04:00:00', NULL, NULL),
(2, 'hospital santa casa', 'st@mail', '8877323', '3232', '645545', '1', 'Rua: Bahia, 8, Nova granada', ' Bh', 'MG', 'teste', '2017-02-06 04:00:00', '2017-02-06 04:00:00', NULL, NULL),
(4, 'Exclusiva', 'exclusiva@mail', '1234567890123', '2323', '98777', '1', 'Rua: 10, 677 itapoã', 'BH', 'MG', 'testamdp', '2017-02-07 21:15:54', '2017-02-07 21:15:54', NULL, NULL),
(6, 'Gst financeira', 'gst@mail', '1234567890125', '33452233', '87777', '1', 'rua: E, 89', 'BH', 'MG', 'gst lib', '2017-02-07 21:18:55', '2017-02-07 22:10:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `debitos`
--

CREATE TABLE `debitos` (
  `id` int(10) UNSIGNED NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_vencimento` datetime DEFAULT NULL,
  `forma_pagamento_id` int(10) UNSIGNED DEFAULT NULL,
  `pagamento_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nome_debito` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  `bank_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `debitos`
--

INSERT INTO `debitos` (`id`, `valor`, `data_vencimento`, `forma_pagamento_id`, `pagamento_id`, `created_at`, `updated_at`, `nome_debito`, `data_pagamento`, `bank_id`) VALUES
(1, '937.00', NULL, 4, 6, '2017-12-20 13:12:16', '2017-12-20 13:12:16', 'Pagamento do salário do josé de Jesus', '2017-12-20 11:12:16', 5),
(2, '450.00', '2017-12-18 00:00:00', 1, 7, '2017-12-20 20:28:51', '2017-12-20 20:28:51', 'Vivo', '2017-12-20 18:28:51', NULL),
(3, '1658.99', '2018-01-31 00:00:00', 1, 16, '2018-01-26 17:20:04', '2018-01-26 17:20:04', 'gasolina', '2018-01-26 15:20:04', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `forma_pagamentos`
--

CREATE TABLE `forma_pagamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipo` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `forma_pagamentos`
--

INSERT INTO `forma_pagamentos` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Dinheiro', '2017-09-08 14:29:00', '2018-01-12 18:53:19'),
(2, 'Cartão de Crédito Mastercard\r\n', '2017-09-08 14:00:00', '2017-09-08 14:00:00'),
(3, 'Boleto Bancário', '2017-08-31 18:18:00', '2017-08-31 18:18:00'),
(4, 'Débito Automático', '2017-08-31 18:18:00', '2017-08-31 18:18:00'),
(5, 'Transferência bancária', '2017-08-31 18:18:00', '2017-08-31 18:18:00'),
(6, 'Cheques', '2017-08-31 18:18:00', '2017-08-31 18:18:00'),
(7, 'Cartão de Crédito Visa', '2017-09-08 14:21:00', '2017-09-08 14:21:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(192) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(23, '2014_10_12_000000_create_users_table', 1),
(24, '2017_01_25_210326_create_officials_table', 1),
(25, '2017_01_26_124501_create_banks_table', 1),
(26, '2017_01_26_124552_create_category_payments_table', 1),
(27, '2017_01_26_124628_create_categorys_receipts_table', 1),
(28, '2017_01_26_124650_create_customers_table', 1),
(29, '2017_01_26_124806_create_companies_banks_table', 1),
(30, '2017_01_26_124901_create_companies_table', 1),
(31, '2017_01_28_191718_create_password_resets_table', 1),
(182, '2014_10_12_100000_create_password_resets_table', 2),
(183, '2017_01_30_152827_create_officials_table', 2),
(184, '2017_02_02_135455_create_receipts_table', 2),
(185, '2017_02_02_135811_create_customers_table', 2),
(186, '2017_02_02_194520_create_companies_table', 2),
(187, '2017_02_08_120449_create_categorys_receipts_table', 2),
(188, '2017_02_10_115333_create_banks_table', 2),
(189, '2017_02_10_115411_create_companies_banks_table', 2),
(190, '2017_03_13_135424_create_admins_table', 2),
(191, '2017_03_16_124946_create_admins_table', 3),
(192, '2017_06_09_223753_create_parcelamentos_table', 3),
(193, '2017_06_16_163746_create_payments_table', 4),
(194, '2017_06_16_163852_create_providers_table', 4),
(195, '2017_06_16_164417_create_category_payments_table', 4),
(196, '2017_06_16_170703_create_parcelamento_pagamentos_table', 5),
(198, '2017_06_16_173939_create_pagamentos_table', 6),
(199, '2017_08_07_112554_create_parcelamento_pagamentos_table', 6),
(200, '2017_08_07_113854_pagamentos_add_coluna', 7),
(201, '2017_08_30_153819_create_creditos_table', 8),
(203, '2017_08_30_154215_create_debitos_table', 9),
(204, '2017_08_30_201202_create_add_fk_creditos_table', 10),
(205, '2017_08_31_112932_create_renomear_creditos_table', 11),
(206, '2017_08_31_173808_create_renomear_debitos_table', 12),
(207, '2017_08_31_174009_create_renomear_table', 13),
(208, '2017_09_08_152105_alterar_creditos_fk_table', 14),
(209, '2017_09_08_154943_add_data_venc_creditos_table', 15),
(210, '2017_09_25_193716_create_data_venc_table', 16),
(211, '2017_09_25_194447_create_data_vencimento_table', 17),
(213, '2017_09_29_181606_create_alterar_empr_cli_forn_table', 19),
(214, '2017_09_29_182310_create_renomear_tabelas_table', 19),
(218, '2017_11_29_100557_deletar_uma_tabela', 23),
(221, '2017_11_30_152320_excluir_tabela', 24),
(222, '2017_11_30_152620_excluir_tabela_cid', 25),
(227, '2014_10_12_200000_create_cidades_table', 26),
(228, '2017_09_29_190934_alterar_coluna_cidades_table', 26),
(244, '2017_11_30_165020_excluir_tblcidades', 27),
(245, '2017_12_01_114401_adicionar_col_tbl_empresa', 27),
(246, '2017_12_01_115742_nova_coluna_empresa', 27),
(247, '2017_12_04_105800_renomear_campo_estado_companie', 27),
(248, '2017_12_05_172610_criar_tbl_debitos', 27),
(249, '2017_12_05_174815_adic_colunas_debitos', 27),
(250, '2017_12_13_110235_cria_tbl_sub_cat_recebimentos', 27),
(251, '2017_12_18_154447_deletar_coluna', 27),
(252, '2017_12_18_161505_deletar_coluna_categoria', 27),
(253, '2017_12_18_163824_adicionar_nova_coluna', 28),
(254, '2017_12_18_225619_renomear_tabela', 29),
(255, '2018_08_26_113108_create_bd_marca_me_table', 30),
(256, '2018_08_26_115332_excluir_table', 30),
(257, '2018_08_26_115810_deletar_table', 31);

-- --------------------------------------------------------

--
-- Estrutura da tabela `officials`
--

CREATE TABLE `officials` (
  `endereco` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `salario` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `telefone_fixo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `telefone_cel` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `officials`
--

INSERT INTO `officials` (`endereco`, `id`, `nome`, `cpf`, `email`, `salario`, `cidade`, `estado`, `telefone_fixo`, `telefone_cel`) VALUES
('99988', 1, 'administrador', '5454545', 'mail@hotmail.com', '1000', 'contagem', 'MG', '9999222', '1'),
(NULL, 2, 'eduardo', '56646464', 'sistema@gstempresarial.com', '2000', 'Bh', 'MG', '', '1'),
(NULL, 3, 'marcos', '6663', 'motorista', '1000', 'SP', 'SP', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_pagamento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `data_vencimento` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `companie_id` int(10) UNSIGNED DEFAULT NULL,
  `provider_id` int(10) UNSIGNED DEFAULT NULL,
  `nota_fiscal_cp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcat_pag_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `nome_pagamento`, `valor`, `status`, `descricao`, `data_vencimento`, `created_at`, `updated_at`, `companie_id`, `provider_id`, `nota_fiscal_cp`, `subcat_pag_id`) VALUES
(6, 'Pagamento do salário do josé de Jesus', '937.00', '1', NULL, '2017-12-18 00:00:00', '2017-12-18 21:52:35', '2017-12-18 23:01:51', 1, NULL, NULL, 2),
(7, 'Vivo', '450.00', '1', NULL, '2017-12-18 00:00:00', '2017-12-18 23:03:07', '2017-12-18 23:03:07', 1, NULL, NULL, 1),
(8, 'Iptu', '120.00', '0', 'teste', '2017-12-20 21:12:22', '2017-12-18 23:06:22', '2017-12-18 23:06:22', 1, NULL, NULL, NULL),
(9, 'Iptu', '120.00', '0', 'teste', '2018-01-20 21:01:22', '2017-12-18 23:06:22', '2017-12-18 23:06:22', 1, NULL, NULL, 3),
(10, 'teste2', '324.00', '0', NULL, '2017-12-29 22:12:29', '2017-12-19 00:42:29', '2017-12-19 00:42:29', 1, NULL, NULL, 2),
(11, 'teste2', '324.00', '0', NULL, '2018-01-29 22:01:29', '2017-12-19 00:42:30', '2017-12-19 00:42:30', 1, NULL, NULL, 2),
(12, 'teste2', '324.00', '0', NULL, '2018-03-01 22:03:29', '2017-12-19 00:42:30', '2017-12-19 00:42:30', 1, NULL, NULL, 2),
(13, 'imposto de renda', '4567.00', '0', NULL, '2017-12-19 00:00:00', '2017-12-19 19:31:01', '2017-12-19 19:31:01', 1, NULL, NULL, NULL),
(14, 'Aluguel de salas', '1000.87', '0', NULL, '2018-01-30 00:00:00', '2018-01-25 13:33:19', '2018-01-25 13:33:19', 1, NULL, NULL, 12),
(16, 'gasolina', '1658.99', '1', NULL, '2018-01-31 00:00:00', '2018-01-25 16:23:15', '2018-01-25 16:23:15', 1, NULL, NULL, 13),
(17, 'conta de água', '1234.55', '0', NULL, '2018-01-30 00:00:00', '2018-01-25 16:27:25', '2018-01-25 16:27:25', 1, NULL, NULL, 8),
(18, 'Compra de produtos de limpeza', '75.00', '0', NULL, '2018-02-16 11:02:13', '2018-02-15 13:08:13', '2018-02-15 13:08:13', 1, NULL, NULL, 15),
(19, 'Compra de produtos de limpeza', '75.00', '0', NULL, '2018-03-16 11:03:13', '2018-02-15 13:08:13', '2018-02-15 13:08:13', 1, NULL, NULL, 15),
(20, 'Compra de produtos de limpeza', '75.00', '0', NULL, '2018-04-16 11:04:13', '2018-02-15 13:08:14', '2018-02-15 13:08:14', 1, NULL, NULL, 15),
(21, 'Compra de produtos de limpeza', '75.00', '0', NULL, '2018-05-16 11:05:13', '2018-02-15 13:08:14', '2018-02-15 13:08:14', 1, NULL, NULL, 15),
(22, 'Pagamento da água Copasa', '560.00', '0', NULL, '2018-09-01 00:00:00', '2018-08-07 19:06:35', '2018-08-07 19:06:35', 1, NULL, NULL, 8),
(23, 'Pagamento da água Copasa', '980.00', '0', NULL, '2018-10-31 00:00:00', '2018-10-22 17:39:58', '2018-10-22 17:39:58', 1, NULL, NULL, 8),
(24, 'telefone vivo', '200.00', '0', NULL, '2018-10-30 00:00:00', '2018-10-22 17:40:37', '2018-10-22 17:40:37', 1, NULL, NULL, 1),
(25, 'Conta de Luz', '400.00', '0', NULL, '2018-11-01 00:00:00', '2018-10-22 17:41:08', '2018-10-22 17:41:08', 1, NULL, NULL, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelamento_pagamentos`
--

CREATE TABLE `parcelamento_pagamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_parcela` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quant_parcelas` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_parcela` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagamento_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `parcelamento_pagamentos`
--

INSERT INTO `parcelamento_pagamentos` (`id`, `nome_parcela`, `quant_parcelas`, `codigo_parcela`, `pagamento_id`, `created_at`, `updated_at`) VALUES
(1, 'Mensal', '2', NULL, 8, '2017-12-18 23:06:22', '2017-12-18 23:06:22'),
(2, 'Mensal', '2', NULL, 9, '2017-12-18 23:06:22', '2017-12-18 23:06:22'),
(3, 'Mensal', '3', NULL, 10, '2017-12-19 00:42:29', '2017-12-19 00:42:29'),
(4, 'Mensal', '3', NULL, 11, '2017-12-19 00:42:30', '2017-12-19 00:42:30'),
(5, 'Mensal', '3', NULL, 12, '2017-12-19 00:42:30', '2017-12-19 00:42:30'),
(6, 'Mensal', '4', NULL, 18, '2018-02-15 13:08:13', '2018-02-15 13:08:13'),
(7, 'Mensal', '4', NULL, 19, '2018-02-15 13:08:13', '2018-02-15 13:08:13'),
(8, 'Mensal', '4', NULL, 20, '2018-02-15 13:08:14', '2018-02-15 13:08:14'),
(9, 'Mensal', '4', NULL, 21, '2018-02-15 13:08:14', '2018-02-15 13:08:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelamento_recebimentos`
--

CREATE TABLE `parcelamento_recebimentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_parcela` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quant_parcelas` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_parcela` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `parcelamento_recebimentos`
--

INSERT INTO `parcelamento_recebimentos` (`id`, `nome_parcela`, `quant_parcelas`, `codigo_parcela`, `receipt_id`, `created_at`, `updated_at`) VALUES
(2, 'Mensal', '3', NULL, 2, '2017-12-20 12:15:26', '2017-12-20 12:15:26'),
(3, 'Mensal', '3', NULL, 3, '2017-12-20 12:15:26', '2017-12-20 12:15:26'),
(5, 'Mensal', '2', NULL, 5, '2017-12-20 15:58:50', '2017-12-20 15:58:50'),
(6, 'Mensal', '3', NULL, 7, '2017-12-20 16:17:19', '2017-12-20 16:17:19'),
(7, 'Mensal', '3', NULL, 8, '2017-12-20 16:17:19', '2017-12-20 16:17:19'),
(8, 'Mensal', '3', NULL, 9, '2017-12-20 16:17:19', '2017-12-20 16:17:19'),
(9, 'Quinzenal', '7', NULL, 14, '2018-02-15 13:00:09', '2018-02-15 13:00:09'),
(10, 'Quinzenal', '7', NULL, 15, '2018-02-15 13:00:09', '2018-02-15 13:00:09'),
(11, 'Quinzenal', '7', NULL, 16, '2018-02-15 13:00:09', '2018-02-15 13:00:09'),
(12, 'Quinzenal', '7', NULL, 17, '2018-02-15 13:00:10', '2018-02-15 13:00:10'),
(13, 'Quinzenal', '7', NULL, 18, '2018-02-15 13:00:10', '2018-02-15 13:00:10'),
(14, 'Quinzenal', '7', NULL, 19, '2018-02-15 13:00:10', '2018-02-15 13:00:10'),
(15, 'Quinzenal', '7', NULL, 20, '2018-02-15 13:00:10', '2018-02-15 13:00:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(192) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(192) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('contato@eduardoaugusto.net.br', '$2y$10$G5LH9zVlAyebR55M8kfHxeSE5h38M05eLZC3zREGNsN533OZMzjr2', '2017-04-07 00:16:34'),
('augustoeduribeiro@yahoo.com.br', '$2y$10$rxBWbuH/KuQI6lKWh1bhyeqPeVo3ynoyn0NtfIE3AuVsAg9H9Kkly', '2017-04-20 23:03:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `providers`
--

CREATE TABLE `providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_fornecedor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnpj_cpf` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_fixo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_celular` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cidade_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `providers`
--

INSERT INTO `providers` (`id`, `nome_fornecedor`, `email`, `cnpj_cpf`, `telefone_fixo`, `telefone_celular`, `status`, `endereco`, `cidade`, `estado`, `descricao`, `created_at`, `updated_at`, `cidade_id`) VALUES
(1, 'cemig', 'atendimento@cemig.com.br', '2323234897635', '233255', '98877', '1', 'Av. Barbacena, 2346', 'BH', 'MG', 'Pagamento da conta de luz', '2017-06-20 03:00:00', '2017-06-20 18:38:01', NULL),
(2, 'Copasa', 'atendimento@copasa.org.br', '2324445789012', '3244', '343434', '1', 'Rua: T, 43', 'BH', 'MG', 'Conta de água', '2017-06-20 18:37:26', '2017-06-20 18:37:26', NULL),
(3, 'Gvt', 'atendimento@gvt.com.br', '1234567890567', '2323233', '54948584', '1', 'Rua: da Serra, 87', 'Curitiba', 'PR', 'conta do telefone fixo', '2017-06-20 18:39:13', '2017-06-20 18:39:13', NULL),
(4, 'Posto Urbano ferraz', 'puf@mail.com', '7632440992324', '23240988', '13877776', '1', 'Av: Amazonas, 43', 'BH', 'MG', 'teste', '2017-08-07 11:46:30', '2017-08-07 11:46:30', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receipts`
--

CREATE TABLE `receipts` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome_recebimento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `data_vencimento` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `companie_id` int(10) UNSIGNED DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `nota_fiscal_cr` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcat_rec_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `receipts`
--

INSERT INTO `receipts` (`id`, `nome_recebimento`, `valor`, `status`, `descricao`, `data_vencimento`, `created_at`, `updated_at`, `companie_id`, `customer_id`, `nota_fiscal_cr`, `subcat_rec_id`) VALUES
(2, 'Venda de produto', '332.00', '1', NULL, '2018-01-20 10:15:25', '2017-12-20 12:15:26', '2017-12-20 12:15:26', 1, NULL, NULL, 1),
(3, 'Venda de produto', '332.00', '0', NULL, '2018-02-20 10:15:25', '2017-12-20 12:15:26', '2017-12-20 12:15:26', 1, NULL, NULL, 1),
(5, 'comissão de serviço extra', '674.00', '1', NULL, '2018-01-21 13:58:49', '2017-12-20 15:58:49', '2017-12-20 15:58:49', 1, NULL, NULL, 2),
(6, 'comissão de serviço', '904.00', '1', NULL, '2017-12-22 00:00:00', '2017-12-20 16:13:27', '2017-12-20 16:13:27', 1, NULL, NULL, 2),
(7, 'Serviços terceiro', '765.00', '2', NULL, '2017-12-28 14:17:19', '2017-12-20 16:17:19', '2018-12-06 17:55:04', 1, NULL, NULL, 3),
(8, 'Serviços terceiro', '765.00', '1', NULL, '2018-01-28 14:17:19', '2017-12-20 16:17:19', '2017-12-20 16:17:19', 1, NULL, NULL, 3),
(9, 'Serviços terceiro', '765.00', '0', NULL, '2018-02-28 14:17:19', '2017-12-20 16:17:19', '2017-12-20 16:17:19', 1, NULL, NULL, 3),
(10, 'Venda de produtos 2', '234.00', '2', NULL, '2017-12-28 00:00:00', '2017-12-20 20:12:46', '2018-12-06 17:55:04', 1, NULL, NULL, 1),
(11, 'Vendas2', '345.00', '2', NULL, '2018-01-18 00:00:00', '2018-01-17 18:14:35', '2018-01-26 17:22:01', 1, NULL, NULL, 1),
(12, 'comissão do Cris', '1234.55', '0', NULL, '2018-01-27 00:00:00', '2018-01-25 16:35:28', '2018-01-25 16:35:28', 1, NULL, NULL, 2),
(13, 'Venda de macbook', '2000.00', '0', NULL, '2018-01-30 00:00:00', '2018-01-26 17:22:00', '2018-01-26 17:22:00', 1, NULL, NULL, 1),
(14, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-02-27 11:00:09', '2018-02-15 13:00:09', '2018-02-15 13:00:09', 1, NULL, NULL, 1),
(15, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-03-14 11:00:09', '2018-02-15 13:00:09', '2018-02-15 13:00:09', 1, NULL, NULL, 1),
(16, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-03-29 11:00:09', '2018-02-15 13:00:09', '2018-02-15 13:00:09', 1, NULL, NULL, 1),
(17, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-04-13 11:00:09', '2018-02-15 13:00:10', '2018-02-15 13:00:10', 1, NULL, NULL, 1),
(18, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-04-28 11:00:09', '2018-02-15 13:00:10', '2018-02-15 13:00:10', 1, NULL, NULL, 1),
(19, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-05-13 11:00:09', '2018-02-15 13:00:10', '2018-02-15 13:00:10', 1, NULL, NULL, 1),
(20, 'Venda de maquinas de café', '250.00', '0', NULL, '2018-05-28 11:00:09', '2018-02-15 13:00:10', '2018-02-15 13:00:10', 1, NULL, NULL, 1),
(21, 'vendas de produto', '300.00', '0', NULL, '2018-08-15 00:00:00', '2018-08-10 19:37:35', '2018-08-10 19:37:35', 1, NULL, NULL, 1),
(22, 'comissão de serviços', '120.00', '0', NULL, '2018-08-21 00:00:00', '2018-08-10 19:38:05', '2018-08-10 19:38:05', 1, NULL, NULL, 2),
(23, 'venda de serviço', '100.00', '0', NULL, '2018-08-29 00:00:00', '2018-08-14 18:34:17', '2018-08-14 18:34:17', 1, NULL, NULL, 1),
(24, 'vendas de produto', '1000.00', '0', NULL, '2018-10-31 00:00:00', '2018-10-22 17:37:40', '2018-10-22 17:37:40', 1, NULL, NULL, 1),
(25, 'comissão de serviços', '500.00', '0', NULL, '2018-10-29 00:00:00', '2018-10-22 17:38:10', '2018-10-22 17:38:10', 1, NULL, NULL, 2),
(26, 'Serviço atendimento', '560.00', '0', NULL, '2018-10-25 00:00:00', '2018-10-22 17:38:53', '2018-10-22 17:38:53', 1, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_cat_pagamentos`
--

CREATE TABLE `sub_cat_pagamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_payment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sub_cat_pagamentos`
--

INSERT INTO `sub_cat_pagamentos` (`id`, `nome`, `descricao`, `created_at`, `updated_at`, `category_payment_id`) VALUES
(1, 'Internet e telefone', 'Internet e telefone', '2017-12-13 04:00:00', '2017-12-18 14:30:30', 1),
(2, 'Salário', NULL, '2017-12-14 19:52:23', '2017-12-14 19:52:23', 3),
(3, 'Impostos e Taxas Estaduais', NULL, '2017-12-15 14:36:38', '2017-12-15 14:36:38', 4),
(5, 'Salário e Gratificações', 'Pagamento de Salários', '2018-01-10 12:02:57', '2018-01-10 12:04:08', 3),
(6, 'Ferias', 'Ferias e 1/3 de Ferias', '2018-01-10 12:03:39', '2018-01-10 12:03:39', 3),
(7, 'Energia Eletrica', 'CEMIG', '2018-01-10 12:05:33', '2018-01-10 12:05:33', 1),
(8, 'Consumo de Agua', 'COPASA', '2018-01-10 12:06:07', '2018-01-10 12:06:07', 1),
(9, 'Material de Escritorio', 'Despesas com Papelaria e itens de Escritorio', '2018-01-10 12:07:46', '2018-01-10 12:07:46', 1),
(10, 'Material de InformÃ¡tica', 'itens e Produtos de Informatica', '2018-01-10 12:08:15', '2018-01-10 12:08:15', 1),
(11, 'AlimentaÃ§Ã£o e Lanches', 'Lanches e AlimentaÃ§Ã£o', '2018-01-10 12:08:50', '2018-01-10 12:44:14', 1),
(12, 'Aluguel e Condominio', 'Despesas com aluguel e Condominio', '2018-01-10 12:09:27', '2018-01-10 12:11:57', 1),
(13, 'Despesas com Combustivel', 'CombustÃ­vel e Lubrificantes', '2018-01-10 12:12:44', '2018-01-10 12:12:44', 1),
(14, 'Viagens e Hospedagem', 'Despesas com Viagens e Hospedagem', '2018-01-10 12:13:13', '2018-01-10 12:13:13', 1),
(15, 'Material de Limpeza', 'Despesas com Material de Limpeza', '2018-01-10 12:13:45', '2018-01-10 12:13:45', 1),
(16, 'HonorÃ¡rios ContÃ¡beis', 'ServiÃ§os de Contabilidade', '2018-01-10 12:14:34', '2018-01-10 12:14:34', 1),
(17, 'HonorÃ¡rios AdvocatÃ­cios', 'HonorÃ¡rios AdvocatÃ­cios', '2018-01-10 12:15:08', '2018-01-10 12:15:08', 1),
(18, 'Despesas com INSS', 'valor do INSS pago pela empresa', '2018-01-10 12:16:31', '2018-01-10 12:16:31', 3),
(19, 'Horas Extras', 'Pagamento de Horas extras', '2018-01-10 12:17:26', '2018-01-10 12:17:26', 3),
(20, 'PrÃªmios e GratificaÃ§Ãµes', 'pagamento de gratificaÃ§Ãµes e PrÃªmios', '2018-01-10 12:18:07', '2018-01-10 12:18:07', 3),
(21, 'Cestas BÃ¡sicas', 'Cestas bÃ¡sicas e outras', '2018-01-10 12:18:38', '2018-01-10 12:18:38', 3),
(22, 'Retiradas de PrÃ³ Labore', 'Pro labore dos sÃ³cios', '2018-01-10 12:19:05', '2018-01-10 12:19:05', 3),
(23, 'AssistÃªncia MÃ©dica', 'Plano de SaÃºde e outros', '2018-01-10 12:19:48', '2018-01-10 12:19:48', 3),
(24, 'Vale Transporte', 'Despesas com Vale Transporte', '2018-01-10 12:25:55', '2018-01-10 12:25:55', 3),
(25, 'Imposto Simples Nacional', 'DAS Simples', '2018-01-10 12:26:19', '2018-01-10 12:26:19', 4),
(26, 'ISS a Recolher', 'Pagamento de ISS', '2018-01-10 12:26:45', '2018-01-10 12:26:45', 4),
(27, 'Taxas Municipais', 'Taxas de LicenÃ§as de Funcionamento Alvara', '2018-01-10 12:27:30', '2018-01-10 12:27:30', 4),
(28, 'Taxas Estaduais', 'Taxa de IncÃªndio e outras', '2018-01-10 12:28:08', '2018-01-10 12:28:08', 4),
(29, 'Impostos Federias', 'Imposto de Renda Retido na fonte', '2018-01-10 12:30:37', '2018-01-10 12:30:37', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_cat_recebimentos`
--

CREATE TABLE `sub_cat_recebimentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_receipt_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sub_cat_recebimentos`
--

INSERT INTO `sub_cat_recebimentos` (`id`, `nome`, `descricao`, `created_at`, `updated_at`, `category_receipt_id`) VALUES
(1, 'Vendas', 'venda de produtos', '2017-12-18 16:30:31', '2017-12-18 16:31:37', 5),
(2, 'Comissão', 'Comissão', '2017-12-18 16:30:58', '2017-12-18 16:30:58', 5),
(3, 'Serviços de Terceiros - Pessoa Jurídica', NULL, '2017-12-20 16:15:09', '2017-12-20 16:15:09', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'atendimento', 'atend@mail.com', '$2y$10$l.ISjPiB6RbuRAKv/H7oR.nHshlhYkdzoZlrDmEKaENod3yASmcye', '4dq24HJodSTIkwC1RSomRadJP89dL6toOijMHxnuc1DJDSAWis7QjzZJRQRT', '2017-03-15 20:25:54', '2017-03-15 20:25:54'),
(4, 'Dudu', 'contato@eduardoaugusto.net.br', '$2y$10$MPLexTznq7Ibkr2sQQxtC.6odyeAoR1vYg7b0xy7xBBTwNAZcskKe', 'bhpsiCypdyQ6c2a9GHj6wo79Qhhxv5TlNn8sX7vusHs4NHSBWsHT8GLcVkPP', '2017-04-04 23:28:53', '2017-04-04 23:28:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banks_nome_unique` (`nome`);

--
-- Indexes for table `category_payments`
--
ALTER TABLE `category_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_receipts`
--
ALTER TABLE `category_receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`),
  ADD UNIQUE KEY `companies_cnpj_cpf_unique` (`cnpj_cpf`),
  ADD KEY `companies_cidade_id_foreign` (`cidade_id`);

--
-- Indexes for table `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creditos_forma_pagamento_id_foreign` (`forma_pagamento_id`),
  ADD KEY `creditos_receipt_id_foreign` (`receipt_id`),
  ADD KEY `creditos_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_cnpj_cpf_unique` (`cnpj_cpf`),
  ADD KEY `customers_cidade_id_foreign` (`cidade_id`);

--
-- Indexes for table `debitos`
--
ALTER TABLE `debitos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debitos_forma_pagamento_id_foreign` (`forma_pagamento_id`),
  ADD KEY `debitos_pagamento_id_foreign` (`pagamento_id`),
  ADD KEY `debitos_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagamentos_companie_id_foreign` (`companie_id`),
  ADD KEY `pagamentos_provider_id_foreign` (`provider_id`),
  ADD KEY `pagamentos_subcat_pag_id_foreign` (`subcat_pag_id`);

--
-- Indexes for table `parcelamento_pagamentos`
--
ALTER TABLE `parcelamento_pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcelamento_pagamentos_pagamento_id_foreign` (`pagamento_id`);

--
-- Indexes for table `parcelamento_recebimentos`
--
ALTER TABLE `parcelamento_recebimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcelamentos_receipt_id_foreign` (`receipt_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `providers_email_unique` (`email`),
  ADD UNIQUE KEY `providers_cnpj_cpf_unique` (`cnpj_cpf`),
  ADD KEY `providers_cidade_id_foreign` (`cidade_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_companie_id_foreign` (`companie_id`),
  ADD KEY `receipts_customer_id_foreign` (`customer_id`),
  ADD KEY `receipts_subcat_rec_id_foreign` (`subcat_rec_id`);

--
-- Indexes for table `sub_cat_pagamentos`
--
ALTER TABLE `sub_cat_pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_cat_pagamentos_category_payment_id_foreign` (`category_payment_id`);

--
-- Indexes for table `sub_cat_recebimentos`
--
ALTER TABLE `sub_cat_recebimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_cat_recebimentos_category_receipt_id_foreign` (`category_receipt_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `category_payments`
--
ALTER TABLE `category_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `category_receipts`
--
ALTER TABLE `category_receipts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9962;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `debitos`
--
ALTER TABLE `debitos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `forma_pagamentos`
--
ALTER TABLE `forma_pagamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `parcelamento_pagamentos`
--
ALTER TABLE `parcelamento_pagamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `parcelamento_recebimentos`
--
ALTER TABLE `parcelamento_recebimentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `sub_cat_pagamentos`
--
ALTER TABLE `sub_cat_pagamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `sub_cat_recebimentos`
--
ALTER TABLE `sub_cat_recebimentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `creditos`
--
ALTER TABLE `creditos`
  ADD CONSTRAINT `creditos_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `creditos_forma_pagamento_id_foreign` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `creditos_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `debitos`
--
ALTER TABLE `debitos`
  ADD CONSTRAINT `debitos_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `debitos_forma_pagamento_id_foreign` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `debitos_pagamento_id_foreign` FOREIGN KEY (`pagamento_id`) REFERENCES `pagamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_companie_id_foreign` FOREIGN KEY (`companie_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagamentos_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagamentos_subcat_pag_id_foreign` FOREIGN KEY (`subcat_pag_id`) REFERENCES `sub_cat_pagamentos` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limitadores para a tabela `parcelamento_pagamentos`
--
ALTER TABLE `parcelamento_pagamentos`
  ADD CONSTRAINT `parcelamento_pagamentos_pagamento_id_foreign` FOREIGN KEY (`pagamento_id`) REFERENCES `pagamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `parcelamento_recebimentos`
--
ALTER TABLE `parcelamento_recebimentos`
  ADD CONSTRAINT `parcelamentos_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_cidade_id_foreign` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_companie_id_foreign` FOREIGN KEY (`companie_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receipts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `receipts_subcat_rec_id_foreign` FOREIGN KEY (`subcat_rec_id`) REFERENCES `sub_cat_recebimentos` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Limitadores para a tabela `sub_cat_pagamentos`
--
ALTER TABLE `sub_cat_pagamentos`
  ADD CONSTRAINT `sub_cat_pagamentos_category_payment_id_foreign` FOREIGN KEY (`category_payment_id`) REFERENCES `category_payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `sub_cat_recebimentos`
--
ALTER TABLE `sub_cat_recebimentos`
  ADD CONSTRAINT `sub_cat_recebimentos_category_receipt_id_foreign` FOREIGN KEY (`category_receipt_id`) REFERENCES `category_receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
