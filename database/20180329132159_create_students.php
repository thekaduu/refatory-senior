<?php


use Phinx\Migration\AbstractMigration;

class CreateStudents extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('students', ['id' => false]);
        $table->addColumn('id', 'integer', ['signed' => true])
            ->addColumn('name', 'string', ['length' => 50])
            ->addColumn('cpf', 'string', ['length' => 11])
            ->addColumn('rg', 'string', ['length' => 14])
            ->addColumn('phone', 'string', ['length' => 13])
            ->addColumn('birthday', 'date')
            ->addTimestamps()
            ->addIndex(['cpf'], ['unique' => true, 'name' => 'idx_students_cpf'])
            ->create();

        $this->execute("CREATE SEQUENCE students_id_seq INCREMENT 1 START 1 MINVALUE 1");
        $this->execute('ALTER TABLE students ADD PRIMARY KEY (id)');
        $this->execute('ALTER TABLE students ALTER id SET DEFAULT nextval(\'students_id_seq\'::regclass)');
    }
}
