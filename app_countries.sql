/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80033 (8.0.33)
 Source Host           : 127.0.0.1:3306
 Source Schema         : databasedefault

 Target Server Type    : MySQL
 Target Server Version : 80033 (8.0.33)
 File Encoding         : 65001

 Date: 06/07/2023 23:54:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_countries
-- ----------------------------
DROP TABLE IF EXISTS `app_countries`;
CREATE TABLE `app_countries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of app_countries
-- ----------------------------
BEGIN;
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (1, 'AF', 'Afeganistão', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (2, 'ZA', 'África do Sul', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (3, 'AL', 'Albânia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (4, 'DE', 'Alemanha', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (5, 'AD', 'Andorra', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (6, 'AO', 'Angola', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (7, 'AI', 'Anguila', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (8, 'AQ', 'Antártida', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (9, 'AG', 'Antígua e Barbuda', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (10, 'SA', 'Arábia Saudita', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (11, 'DZ', 'Argélia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (12, 'AR', 'Argentina', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (13, 'AM', 'Arménia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (14, 'AW', 'Aruba', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (15, 'AU', 'Austrália', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (16, 'AT', 'Áustria', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (17, 'AZ', 'Azerbaijão', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (18, 'BS', 'Bahamas', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (19, 'BH', 'Bahrein', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (20, 'BD', 'Bangladesh', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (21, 'BB', 'Barbados', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (22, 'BE', 'Bélgica', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (23, 'BZ', 'Belize', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (24, 'BJ', 'Benim', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (25, 'BM', 'Bermudas', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (26, 'BY', 'Bielorrússia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (27, 'BO', 'Bolívia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (28, 'BA', 'Bósnia-Herzegovina', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (29, 'BW', 'Botsuana', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (30, 'BR', 'Brasil', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (31, 'BN', 'Brunei', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (32, 'BG', 'Bulgária', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (33, 'BF', 'Burkina Faso', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (34, 'BI', 'Burundi', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (35, 'BT', 'Butão', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (36, 'CV', 'Cabo Verde', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (37, 'KH', 'Camboja', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (38, 'CA', 'Canadá', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (39, 'QA', 'Qatar', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (40, 'KZ', 'Cazaquistão', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (41, 'TD', 'Chade', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (42, 'CL', 'Chile', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (43, 'CN', 'China', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (44, 'CY', 'Chipre', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (45, 'VA', 'Santa Sé', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (46, 'SG', 'Singapura', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (47, 'CO', 'Colômbia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (48, 'KM', 'Comores', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (49, 'CG', 'República Democrática do Congo', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (50, 'CD', 'República Popular do Congo', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (51, 'KP', 'Coreia do Norte', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (52, 'KR', 'Coreia do Sul', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (53, 'CI', 'Costa do Marfim', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (54, 'CR', 'Costa Rica', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (55, 'HR', 'Croácia', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (56, 'CU', 'Cuba', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (57, 'CW', 'Curaçao', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (58, 'DK', 'Dinamarca', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (59, 'DJ', 'Djibouti', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (60, 'DM', 'Dominica', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (61, 'EG', 'Egito', '2023-07-07 02:05:51', '2023-07-07 02:05:51');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (62, 'SV', 'El Salvador', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (63, 'AE', 'Emirados Árabes Unidos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (64, 'EC', 'Equador', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (65, 'ER', 'Eritreia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (66, 'SK', 'Eslováquia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (67, 'SI', 'Eslovénia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (68, 'ES', 'Espanha', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (69, 'US', 'Estados Unidos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (70, 'EE', 'Estónia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (71, 'ET', 'Etiópia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (72, 'FJ', 'Fiji', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (73, 'PH', 'Filipinas', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (74, 'FI', 'Finlândia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (75, 'FR', 'França', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (76, 'GA', 'Gabão', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (77, 'GM', 'Gâmbia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (78, 'GH', 'Gana', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (79, 'GE', 'Geórgia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (80, 'GS', 'Geórgia do Sul e Ilhas Sandwich do Sul', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (81, 'GI', 'Gibraltar', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (82, 'GD', 'Granada', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (83, 'GR', 'Grécia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (84, 'GL', 'Gronelândia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (85, 'GP', 'Guadalupe', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (86, 'GU', 'Guam', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (87, 'GT', 'Guatemala', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (88, 'GG', 'Guernsey', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (89, 'GY', 'Guiana', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (90, 'GF', 'Guiana Francesa', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (91, 'GN', 'Guiné', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (92, 'GW', 'Guiné-Bissau', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (93, 'GQ', 'Guiné Equatorial', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (94, 'HT', 'Haiti', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (95, 'NL', 'Países Baixos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (96, 'HN', 'Honduras', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (97, 'HK', 'Hong Kong', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (98, 'HU', 'Hungria', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (99, 'YE', 'Iémen', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (100, 'BV', 'Ilha Bouvet', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (101, 'CX', 'Ilha de Natal', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (102, 'IM', 'Ilha de Man', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (103, 'NF', 'Ilha Norfolk', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (104, 'AX', 'Ilhas Åland', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (105, 'KY', 'Ilhas Caimão', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (106, 'CC', 'Ilhas Cocos (Keeling)', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (107, 'CK', 'Ilhas Cook', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (108, 'UM', 'Ilhas Distantes dos EUA', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (109, 'HM', 'Ilha Heard e Ilhas McDonald', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (110, 'FO', 'Ilhas Faroé', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (111, 'FK', 'Ilhas Malvinas', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (112, 'MP', 'Ilhas Marianas do Norte', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (113, 'MH', 'Ilhas Marshall', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (114, 'PN', 'Ilhas Pitcairn', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (115, 'SB', 'Ilhas Salomão', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (116, 'TC', 'Ilhas Turcas e Caicos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (117, 'VG', 'Ilhas Virgens Britânicas', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (118, 'VI', 'Ilhas Virgens Americanas', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (119, 'IN', 'Índia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (120, 'ID', 'Indonésia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (121, 'IR', 'Irão', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (122, 'IQ', 'Iraque', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (123, 'IE', 'Irlanda', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (124, 'IS', 'Islândia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (125, 'IL', 'Israel', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (126, 'IT', 'Itália', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (127, 'JM', 'Jamaica', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (128, 'JP', 'Japão', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (129, 'JE', 'Jersey', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (130, 'JO', 'Jordânia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (131, 'KW', 'Koweit', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (132, 'LA', 'Laos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (133, 'LS', 'Lesoto', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (134, 'LV', 'Letónia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (135, 'LB', 'Líbano', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (136, 'LR', 'Libéria', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (137, 'LY', 'Líbia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (138, 'LI', 'Liechtenstein', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (139, 'LT', 'Lituânia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (140, 'LU', 'Luxemburgo', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (141, 'MO', 'Macau', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (142, 'MK', 'Macedónia do Norte', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (143, 'MG', 'Madagáscar', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (144, 'MY', 'Malásia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (145, 'MW', 'Maláui', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (146, 'MV', 'Maldivas', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (147, 'ML', 'Mali', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (148, 'MT', 'Malta', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (149, 'MA', 'Marrocos', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (150, 'MQ', 'Martinica', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (151, 'MU', 'Maurícia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (152, 'MR', 'Mauritânia', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (153, 'YT', 'Mayotte', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (154, 'MX', 'México', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (155, 'MM', 'Mianmar (Birmânia)', '2023-07-07 02:09:05', '2023-07-07 02:09:05');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (156, 'FM', 'Micronésia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (157, 'MZ', 'Moçambique', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (158, 'MD', 'Moldávia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (159, 'MC', 'Mónaco', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (160, 'MN', 'Mongólia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (161, 'ME', 'Montenegro', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (162, 'MS', 'Monserrate', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (163, 'NA', 'Namíbia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (164, 'NR', 'Nauru', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (165, 'NP', 'Nepal', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (166, 'NI', 'Nicarágua', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (167, 'NE', 'Níger', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (168, 'NG', 'Nigéria', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (169, 'NU', 'Niue', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (170, 'NO', 'Noruega', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (171, 'NC', 'Nova Caledónia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (172, 'NZ', 'Nova Zelândia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (173, 'OM', 'Omã', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (174, 'BQ', 'Países Baixos Caribenhos', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (175, 'PW', 'Palau', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (176, 'PA', 'Panamá', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (177, 'PG', 'Papua-Nova Guiné', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (178, 'PK', 'Paquistão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (179, 'PY', 'Paraguai', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (180, 'PE', 'Peru', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (181, 'PF', 'Polinésia Francesa', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (182, 'PL', 'Polónia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (183, 'PR', 'Porto Rico', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (184, 'PT', 'Portugal', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (185, 'KE', 'Quénia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (186, 'KG', 'Quirguistão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (187, 'KI', 'Quiribati', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (188, 'GB', 'Reino Unido', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (189, 'CF', 'República Centro-Africana', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (190, 'DO', 'República Dominicana', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (191, 'CM', 'Camarões', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (192, 'CZ', 'Chéquia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (193, 'RE', 'Reunião', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (194, 'RO', 'Roménia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (195, 'RW', 'Ruanda', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (196, 'RU', 'Rússia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (197, 'EH', 'Saara Ocidental', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (198, 'PM', 'Saint Pierre e Miquelon', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (199, 'WS', 'Samoa', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (200, 'AS', 'Samoa Americana', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (201, 'SM', 'San Marino', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (202, 'SH', 'Santa Helena', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (203, 'LC', 'Santa Lúcia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (204, 'BL', 'São Bartolomeu', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (205, 'KN', 'São Cristóvão e Neves', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (206, 'MF', 'São Martinho', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (207, 'ST', 'São Tomé e Príncipe', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (208, 'VC', 'São Vicente e Granadinas', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (209, 'SN', 'Senegal', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (210, 'SL', 'Serra Leoa', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (211, 'RS', 'Sérvia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (212, 'SC', 'Seychelles', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (213, 'SX', 'São Martinho', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (214, 'SY', 'Síria', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (215, 'SO', 'Somália', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (216, 'LK', 'Sri Lanka', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (217, 'SZ', 'Essuatíni', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (218, 'SD', 'Sudão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (219, 'SS', 'Sudão do Sul', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (220, 'SE', 'Suécia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (221, 'CH', 'Suíça', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (222, 'SR', 'Suriname', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (223, 'SJ', 'Svalbard e Jan Mayen', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (224, 'TH', 'Tailândia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (225, 'TW', 'Taiwan', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (226, 'TJ', 'Tajiquistão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (227, 'TZ', 'Tanzânia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (228, 'IO', 'Território Britânico do Oceano Índico', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (229, 'TF', 'Terras Austrais e Antárticas Francesas', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (230, 'PS', 'Territórios palestinos', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (231, 'TL', 'Timor-Leste', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (232, 'TG', 'Togo', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (233, 'TK', 'Tokelau', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (234, 'TO', 'Tonga', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (235, 'TT', 'Trindade e Tobago', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (236, 'TN', 'Tunísia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (237, 'TM', 'Turquemenistão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (238, 'TR', 'Turquia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (239, 'TV', 'Tuvalu', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (240, 'UA', 'Ucrânia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (241, 'UG', 'Uganda', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (242, 'UY', 'Uruguai', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (243, 'UZ', 'Uzbequistão', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (244, 'VU', 'Vanuatu', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (245, 'VE', 'Venezuela', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (246, 'VN', 'Vietname', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (247, 'WF', 'Wallis e Futuna', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (248, 'ZM', 'Zâmbia', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (249, 'ZW', 'Zimbábue', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
INSERT INTO `app_countries` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES (250, 'XK', 'Kosovo', '2023-07-07 02:10:52', '2023-07-07 02:10:52');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
