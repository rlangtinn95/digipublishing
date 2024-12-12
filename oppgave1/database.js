import mysql from 'mysql2'

 const pool = mysql.createPool({
      host: '127.0.0.1',
      user: 'root',
      password: 'nynur559',
      database: 'registration_schema'
}).promise()

export async function getPersonalInfo(){

const [rows] = await pool.query("SELECT * FROM personal_information")
return rows
}

export async function getSingleInfo(id){

      const [rows] = await pool.query(
            `SELECT * 
            FROM personal_information
            WHERE id = ?
            `, [id])
      return rows[0]
}

 export async function createPersonalInfo(first_name, last_name, e_mail, phone_number, birth_date){
      const [result] = await pool.query(`
      INSERT INTO personal_information 
      (first_name, 
      last_name, 
      e_mail, 
      phone_number, 
      birth_date)
      VALUES (?, ?, ?, ?, ?)`, [first_name, last_name, e_mail, phone_number, birth_date])
      const id = result.insertId
      return getSingleInfo(id)
}
 
console.log(createPersonalInfo)
// const result = await createPersonalInfo('test','test','test@test.com','90909090','1990-05-04')
// console.log(result)

// const single_personal_information = await getSingleInformation(1)

// console.log(single_personal_information)