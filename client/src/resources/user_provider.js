import HttpRequest from './http_request'

class UserProvider extends HttpRequest {
  constructor () {
    // API Endpoint url
    super(process.env.VUE_APP_ROOT_API + 'search/')
  }

  async getUser (path) {
    const { data } = await this.get(path)
    return data
  }
}

export default UserProvider
