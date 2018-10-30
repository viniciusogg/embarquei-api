<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20181024140646 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pontos_parada (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', trajeto_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, ordem INT NOT NULL, INDEX IDX_7AA975AA5FD436D8 (trajeto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horarios_semanais_estudantes (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', estudante_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', dia_semana VARCHAR(255) NOT NULL, INDEX IDX_A3B1F63B3B4690DB (estudante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, sobrenome VARCHAR(255) NOT NULL, numero_celular VARCHAR(255) NOT NULL, ativo TINYINT(1) NOT NULL, senha VARCHAR(255) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EF687F23A5CBB1E (numero_celular), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mensageiros (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motoristas (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', foto VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5CFD06CDEADC3BE5 (foto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enderecos (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cidade_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', logradouro VARCHAR(255) NOT NULL, bairro VARCHAR(255) NOT NULL, INDEX IDX_FC4E02DA9586CC8 (cidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cursos (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', instituicao_ensino_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, INDEX IDX_B2785A18CFA13933 (instituicao_ensino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rotas (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cidade_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, INDEX IDX_C067190B9586CC8 (cidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instituicao_ensino_rota (rota_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', instituicao_ensino_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_101CE2259F169B8 (rota_id), INDEX IDX_101CE225CFA13933 (instituicao_ensino_id), PRIMARY KEY(rota_id, instituicao_ensino_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listas_presenca (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', instituicao_ensino_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cidade_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_F8161059CFA13933 (instituicao_ensino_id), INDEX IDX_F81610599586CC8 (cidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajetos (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', horario_trajeto_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', rota_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', url_mapa VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_528CA241AAC3B055 (url_mapa), UNIQUE INDEX UNIQ_528CA241E5CE6D0 (horario_trajeto_id), INDEX IDX_528CA2419F169B8 (rota_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comprovantes_matricula (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', caminho_sistema_arquivos VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, data_envio DATETIME NOT NULL, justificativa VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_423DF07C227C5A45 (caminho_sistema_arquivos), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horarios_trajeto (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', partida TIME NOT NULL, chegada TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renovacoes_cadastro (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', responsavel_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', ativa TINYINT(1) NOT NULL, INDEX IDX_B350766FBB9AF004 (responsavel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudante_renovacao_cadastro (renovacao_cadastro_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', estudante_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6F05BA9C82BB25E (renovacao_cadastro_id), INDEX IDX_6F05BA93B4690DB (estudante_id), PRIMARY KEY(renovacao_cadastro_id, estudante_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veiculos_transporte (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cidade_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', capacidade INT NOT NULL, placa VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, cor VARCHAR(255) NOT NULL, imagem VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_ECF39B37737097D4 (placa), UNIQUE INDEX UNIQ_ECF39B371A108309 (imagem), INDEX IDX_ECF39B379586CC8 (cidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notificacoes (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', remetente_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', titulo VARCHAR(255) NOT NULL, descricao VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, data_envio DATETIME NOT NULL, INDEX IDX_EFFEE10DFA0A674B (remetente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cidades (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_79B94AE754BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instituicoes_ensino (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', endereco_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_165F7F1854BD530C (nome), UNIQUE INDEX UNIQ_165F7F181BB76823 (endereco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instituicao_ensino_motorista (instituicao_ensino_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', motorista_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_47954A5CCFA13933 (instituicao_ensino_id), INDEX IDX_47954A5C1959881F (motorista_id), PRIMARY KEY(instituicao_ensino_id, motorista_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instituicao_ensino_veiculo_transporte (instituicao_ensino_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', veiculo_transporte_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_14D7541BCFA13933 (instituicao_ensino_id), INDEX IDX_14D7541B6120DAE4 (veiculo_transporte_id), PRIMARY KEY(instituicao_ensino_id, veiculo_transporte_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checkins (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', estudante_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', lista_presenca_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', confirmado TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9CE70FC53B4690DB (estudante_id), INDEX IDX_9CE70FC5A58DDEE9 (lista_presenca_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudantes (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', curso_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', endereco_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', comprovante_matricula_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', foto VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E590D4DDEADC3BE5 (foto), INDEX IDX_E590D4DD87CB4A1F (curso_id), UNIQUE INDEX UNIQ_E590D4DD1BB76823 (endereco_id), UNIQUE INDEX UNIQ_E590D4DD91E6CFE (comprovante_matricula_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudante_ponto_parada (estudante_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', ponto_parada_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DBA8DC1F3B4690DB (estudante_id), INDEX IDX_DBA8DC1F7139120E (ponto_parada_id), PRIMARY KEY(estudante_id, ponto_parada_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administradores (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', endereco_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_BA7CABE61BB76823 (endereco_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE pontos_parada ADD CONSTRAINT FK_7AA975AA5FD436D8 FOREIGN KEY (trajeto_id) REFERENCES trajetos (id)');
        $this->addSql('ALTER TABLE horarios_semanais_estudantes ADD CONSTRAINT FK_A3B1F63B3B4690DB FOREIGN KEY (estudante_id) REFERENCES estudantes (id)');
        $this->addSql('ALTER TABLE mensageiros ADD CONSTRAINT FK_22A7BA75BF396750 FOREIGN KEY (id) REFERENCES usuarios (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motoristas ADD CONSTRAINT FK_5CFD06CDBF396750 FOREIGN KEY (id) REFERENCES usuarios (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enderecos ADD CONSTRAINT FK_FC4E02DA9586CC8 FOREIGN KEY (cidade_id) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE cursos ADD CONSTRAINT FK_B2785A18CFA13933 FOREIGN KEY (instituicao_ensino_id) REFERENCES instituicoes_ensino (id)');
        $this->addSql('ALTER TABLE rotas ADD CONSTRAINT FK_C067190B9586CC8 FOREIGN KEY (cidade_id) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE instituicao_ensino_rota ADD CONSTRAINT FK_101CE2259F169B8 FOREIGN KEY (rota_id) REFERENCES rotas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instituicao_ensino_rota ADD CONSTRAINT FK_101CE225CFA13933 FOREIGN KEY (instituicao_ensino_id) REFERENCES instituicoes_ensino (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listas_presenca ADD CONSTRAINT FK_F8161059CFA13933 FOREIGN KEY (instituicao_ensino_id) REFERENCES instituicoes_ensino (id)');
        $this->addSql('ALTER TABLE listas_presenca ADD CONSTRAINT FK_F81610599586CC8 FOREIGN KEY (cidade_id) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE trajetos ADD CONSTRAINT FK_528CA241E5CE6D0 FOREIGN KEY (horario_trajeto_id) REFERENCES horarios_trajeto (id)');
        $this->addSql('ALTER TABLE trajetos ADD CONSTRAINT FK_528CA2419F169B8 FOREIGN KEY (rota_id) REFERENCES rotas (id)');
        $this->addSql('ALTER TABLE renovacoes_cadastro ADD CONSTRAINT FK_B350766FBB9AF004 FOREIGN KEY (responsavel_id) REFERENCES administradores (id)');
        $this->addSql('ALTER TABLE estudante_renovacao_cadastro ADD CONSTRAINT FK_6F05BA9C82BB25E FOREIGN KEY (renovacao_cadastro_id) REFERENCES renovacoes_cadastro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE estudante_renovacao_cadastro ADD CONSTRAINT FK_6F05BA93B4690DB FOREIGN KEY (estudante_id) REFERENCES estudantes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE veiculos_transporte ADD CONSTRAINT FK_ECF39B379586CC8 FOREIGN KEY (cidade_id) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE notificacoes ADD CONSTRAINT FK_EFFEE10DFA0A674B FOREIGN KEY (remetente_id) REFERENCES mensageiros (id)');
        $this->addSql('ALTER TABLE instituicoes_ensino ADD CONSTRAINT FK_165F7F181BB76823 FOREIGN KEY (endereco_id) REFERENCES enderecos (id)');
        $this->addSql('ALTER TABLE instituicao_ensino_motorista ADD CONSTRAINT FK_47954A5CCFA13933 FOREIGN KEY (instituicao_ensino_id) REFERENCES instituicoes_ensino (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instituicao_ensino_motorista ADD CONSTRAINT FK_47954A5C1959881F FOREIGN KEY (motorista_id) REFERENCES motoristas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instituicao_ensino_veiculo_transporte ADD CONSTRAINT FK_14D7541BCFA13933 FOREIGN KEY (instituicao_ensino_id) REFERENCES instituicoes_ensino (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instituicao_ensino_veiculo_transporte ADD CONSTRAINT FK_14D7541B6120DAE4 FOREIGN KEY (veiculo_transporte_id) REFERENCES veiculos_transporte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE checkins ADD CONSTRAINT FK_9CE70FC53B4690DB FOREIGN KEY (estudante_id) REFERENCES estudantes (id)');
        $this->addSql('ALTER TABLE checkins ADD CONSTRAINT FK_9CE70FC5A58DDEE9 FOREIGN KEY (lista_presenca_id) REFERENCES listas_presenca (id)');
        $this->addSql('ALTER TABLE estudantes ADD CONSTRAINT FK_E590D4DD87CB4A1F FOREIGN KEY (curso_id) REFERENCES cursos (id)');
        $this->addSql('ALTER TABLE estudantes ADD CONSTRAINT FK_E590D4DD1BB76823 FOREIGN KEY (endereco_id) REFERENCES enderecos (id)');
        $this->addSql('ALTER TABLE estudantes ADD CONSTRAINT FK_E590D4DD91E6CFE FOREIGN KEY (comprovante_matricula_id) REFERENCES comprovantes_matricula (id)');
        $this->addSql('ALTER TABLE estudantes ADD CONSTRAINT FK_E590D4DDBF396750 FOREIGN KEY (id) REFERENCES usuarios (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE estudante_ponto_parada ADD CONSTRAINT FK_DBA8DC1F3B4690DB FOREIGN KEY (estudante_id) REFERENCES estudantes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE estudante_ponto_parada ADD CONSTRAINT FK_DBA8DC1F7139120E FOREIGN KEY (ponto_parada_id) REFERENCES pontos_parada (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administradores ADD CONSTRAINT FK_BA7CABE61BB76823 FOREIGN KEY (endereco_id) REFERENCES enderecos (id)');
        $this->addSql('ALTER TABLE administradores ADD CONSTRAINT FK_BA7CABE6BF396750 FOREIGN KEY (id) REFERENCES usuarios (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE estudante_ponto_parada DROP FOREIGN KEY FK_DBA8DC1F7139120E');
        $this->addSql('ALTER TABLE mensageiros DROP FOREIGN KEY FK_22A7BA75BF396750');
        $this->addSql('ALTER TABLE motoristas DROP FOREIGN KEY FK_5CFD06CDBF396750');
        $this->addSql('ALTER TABLE estudantes DROP FOREIGN KEY FK_E590D4DDBF396750');
        $this->addSql('ALTER TABLE administradores DROP FOREIGN KEY FK_BA7CABE6BF396750');
        $this->addSql('ALTER TABLE notificacoes DROP FOREIGN KEY FK_EFFEE10DFA0A674B');
        $this->addSql('ALTER TABLE instituicao_ensino_motorista DROP FOREIGN KEY FK_47954A5C1959881F');
        $this->addSql('ALTER TABLE instituicoes_ensino DROP FOREIGN KEY FK_165F7F181BB76823');
        $this->addSql('ALTER TABLE estudantes DROP FOREIGN KEY FK_E590D4DD1BB76823');
        $this->addSql('ALTER TABLE administradores DROP FOREIGN KEY FK_BA7CABE61BB76823');
        $this->addSql('ALTER TABLE estudantes DROP FOREIGN KEY FK_E590D4DD87CB4A1F');
        $this->addSql('ALTER TABLE instituicao_ensino_rota DROP FOREIGN KEY FK_101CE2259F169B8');
        $this->addSql('ALTER TABLE trajetos DROP FOREIGN KEY FK_528CA2419F169B8');
        $this->addSql('ALTER TABLE checkins DROP FOREIGN KEY FK_9CE70FC5A58DDEE9');
        $this->addSql('ALTER TABLE pontos_parada DROP FOREIGN KEY FK_7AA975AA5FD436D8');
        $this->addSql('ALTER TABLE estudantes DROP FOREIGN KEY FK_E590D4DD91E6CFE');
        $this->addSql('ALTER TABLE trajetos DROP FOREIGN KEY FK_528CA241E5CE6D0');
        $this->addSql('ALTER TABLE estudante_renovacao_cadastro DROP FOREIGN KEY FK_6F05BA9C82BB25E');
        $this->addSql('ALTER TABLE instituicao_ensino_veiculo_transporte DROP FOREIGN KEY FK_14D7541B6120DAE4');
        $this->addSql('ALTER TABLE enderecos DROP FOREIGN KEY FK_FC4E02DA9586CC8');
        $this->addSql('ALTER TABLE rotas DROP FOREIGN KEY FK_C067190B9586CC8');
        $this->addSql('ALTER TABLE listas_presenca DROP FOREIGN KEY FK_F81610599586CC8');
        $this->addSql('ALTER TABLE veiculos_transporte DROP FOREIGN KEY FK_ECF39B379586CC8');
        $this->addSql('ALTER TABLE cursos DROP FOREIGN KEY FK_B2785A18CFA13933');
        $this->addSql('ALTER TABLE instituicao_ensino_rota DROP FOREIGN KEY FK_101CE225CFA13933');
        $this->addSql('ALTER TABLE listas_presenca DROP FOREIGN KEY FK_F8161059CFA13933');
        $this->addSql('ALTER TABLE instituicao_ensino_motorista DROP FOREIGN KEY FK_47954A5CCFA13933');
        $this->addSql('ALTER TABLE instituicao_ensino_veiculo_transporte DROP FOREIGN KEY FK_14D7541BCFA13933');
        $this->addSql('ALTER TABLE horarios_semanais_estudantes DROP FOREIGN KEY FK_A3B1F63B3B4690DB');
        $this->addSql('ALTER TABLE estudante_renovacao_cadastro DROP FOREIGN KEY FK_6F05BA93B4690DB');
        $this->addSql('ALTER TABLE checkins DROP FOREIGN KEY FK_9CE70FC53B4690DB');
        $this->addSql('ALTER TABLE estudante_ponto_parada DROP FOREIGN KEY FK_DBA8DC1F3B4690DB');
        $this->addSql('ALTER TABLE renovacoes_cadastro DROP FOREIGN KEY FK_B350766FBB9AF004');
        $this->addSql('DROP TABLE pontos_parada');
        $this->addSql('DROP TABLE horarios_semanais_estudantes');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE mensageiros');
        $this->addSql('DROP TABLE motoristas');
        $this->addSql('DROP TABLE enderecos');
        $this->addSql('DROP TABLE cursos');
        $this->addSql('DROP TABLE rotas');
        $this->addSql('DROP TABLE instituicao_ensino_rota');
        $this->addSql('DROP TABLE listas_presenca');
        $this->addSql('DROP TABLE trajetos');
        $this->addSql('DROP TABLE comprovantes_matricula');
        $this->addSql('DROP TABLE horarios_trajeto');
        $this->addSql('DROP TABLE renovacoes_cadastro');
        $this->addSql('DROP TABLE estudante_renovacao_cadastro');
        $this->addSql('DROP TABLE veiculos_transporte');
        $this->addSql('DROP TABLE notificacoes');
        $this->addSql('DROP TABLE cidades');
        $this->addSql('DROP TABLE instituicoes_ensino');
        $this->addSql('DROP TABLE instituicao_ensino_motorista');
        $this->addSql('DROP TABLE instituicao_ensino_veiculo_transporte');
        $this->addSql('DROP TABLE checkins');
        $this->addSql('DROP TABLE estudantes');
        $this->addSql('DROP TABLE estudante_ponto_parada');
        $this->addSql('DROP TABLE administradores');
    }
}
