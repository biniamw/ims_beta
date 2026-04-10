import axios from 'axios';
async function callAPI(){
const response = await axios.post(
    'https://tiltek.et/api/v1/customer/ACCOUNTID',
    {
        'to': [
            '0912926245'
        ],
        'body': `Hello There`,
        'codeId': 'CODE_ID'
    },
    {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        auth: {
            username: 'ACCOUNTID',
            password: 'token'
        }
    }
);
}

callAPI();
