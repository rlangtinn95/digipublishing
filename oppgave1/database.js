import mysql from 'mysql2'
import dotenv from 'dotenv'
dotenv.config()

 const pool = mysql.createPool({
      host: process.env.MYSQL_HOST,
      user: process.env.MYSQL_USER,
      password: process.env.MYSQL_PASSWORD,
      database: process.env.MYSQL_DATABASE
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
