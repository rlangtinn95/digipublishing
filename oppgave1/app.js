import express from 'express'
import { getPersonalInfo, getSingleInfo, createPersonalInfo } from './database.js'
import path from 'path'

const app = express()

app.use(express.json())

app.use(express.static(path.join(process.cwd(), 'public')));


app.get("/", (req, res) => {
      res.sendFile(path.join(process.cwd(), 'public', 'index.html'));
  });

app.get("/info", async (req, res) =>{
      const info = await getPersonalInfo()
      res.send(info)
})


app.get("/info/:id", async (req, res) =>{
      const id = req.params.id
      const infoid = await getSingleInfo(id)
      res.send(infoid)
})

app.post("/info", async (req, res) => {
      const {first_name, last_name, e_mail, phone_number, birth_date} = req.body
      const infoid = await createPersonalInfo(first_name, last_name, e_mail, phone_number, birth_date)
      res.status(201).send(infoid)
})



app.use((err, req, res, next) => {
      console.error(err.stack)
      res.status(500).send('Something broke!')
    })

    app.listen(8080, () => {
      console.log('Server is running on port 8080')
    })