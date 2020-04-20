--
-- Estrutura da tabela `interacoes`
--

CREATE TABLE IF NOT EXISTS `interacoes` (
  `nm_usuario` varchar(20) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `dt_interacao` datetime NOT NULL,
  `ds_interacao` varchar(500) NOT NULL,
  `nm_destinatario` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `salas`
--

CREATE TABLE IF NOT EXISTS `salas` (
  `id_sala` int(11) NOT NULL AUTO_INCREMENT,
  `nm_sala` varchar(20) NOT NULL,
  PRIMARY KEY (`id_sala`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `salas` (`id_sala`, `nm_sala`) VALUES
(1, 'Programação'),
(2, 'Jogos'),
(3, 'Música');

-- --------------------------------------------------------
--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(20) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `dt_refresh` datetime NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nm_usuario`, `id_sala`, `dt_refresh`) VALUES
(1, 'Ueslei', 3, '2020-04-17 12:00:00');