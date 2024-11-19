import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head, Link, useForm} from "@inertiajs/react";
import InputLabel from "@/Components/InputLabel.jsx";
import TextInput from "@/Components/TextInput.jsx";
import {Textarea} from "@headlessui/react";
import InputError from "@/Components/InputError.jsx";
import TextAreaInput from "@/Components/TextAreaInput.jsx";

export default function Index({auth, lead_id}) {
  const { data, setData, post, errors, reset } = useForm({
    lead_id: lead_id,
    name: "",
    phone: "",
    common_note: "",
  })

  const onSubmit = (e) => {
    e.preventDefault();

    post(route("contact.store"));
  }

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800
        dark:text-gray-200 leading-tight">
          Привязка контакта
        </h2>
      }
    >
      <Head title="Привязка контакта"/>

      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <form onSubmit={onSubmit}
                    className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div>
                  <InputLabel htmlFor="name"
                              value="Имя контакта"
                  />
                  <TextInput id="name"
                             type="text"
                             name="name"
                             value={data.name}
                             className="mt-1 bolck w-full"
                             onChange={e => setData('name', e.target.value)}
                  />
                </div>
                <div className="mt-4">
                  <InputLabel htmlFor="phone"
                              value="Телефон контакта"
                  />
                  <TextInput id="phone"
                             type="text"
                             name="phone"
                             value={data.phone}
                             className="mt-1 bolck w-full"
                             onChange={e => setData('phone', e.target.value)}
                  />
                </div>
                <div className="mt-4">
                  <InputLabel htmlFor="common_note"
                              value="Комментарий"
                  />
                  <TextAreaInput id="common_note"
                                 name="common_note"
                                 value={data.common_note}
                                 className="mt-1 bolck w-full"
                                 onChange={e => setData('common_note', e.target.value)}
                  />

                  <InputError message={errors.name} className="mt-2"/>
                </div>
                <div className="mt-4 text-right">
                  <Link href={route('leads')}
                        className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow
                                   transition-all hover:bg-gray-200 mr-2 inline-block">
                    Отмена
                  </Link>
                  <button type="submit"
                          className="bg-emerald-500 py-1 px-3 text-white rounded shadow
                                     transition-all hover:bg-emerald-600">
                    Привязать
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}
