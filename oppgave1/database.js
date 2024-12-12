import mysql from 'mysql2'

 const pool = mysql.createPool({
      host: '127.0.0.1',
      user: 'root',
      password: 'nynur559',
      database: 'registration_schema'
}).promise()

async function getPersonalInformation(){

const [rows] = await pool.query("SELECT * FROM personal_information")
return rows
}

const personal_information = await getPersonalInformation()

console.log(personal_information)