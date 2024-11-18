import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head, Link} from "@inertiajs/react";
import Pagination from "@/Components/Pagination.jsx";
import {LEAD_HAS_CONTACT_TEXT_MAP, SUCCESS_CLASS_MAP} from "@/constants.js";

export default function Index({auth, leads}) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800
        dark:text-gray-200 leading-tight">
          Выбор сделки
        </h2>
      }
    >
      <Head title="Выбор сделки"/>

      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700
                                  dark:text-gray-400 border-b-2 border-gray-500">
                <tr className="text-nowrap">
                  <th className="px-3 py-2">ID сделки</th>
                  <th className="px-3 py-2">Название</th>
                  <th className="px-3 py-2">Дата создания</th>
                  <th className="px-3 py-2">Контакт привязан</th>
                  <th className="px-3 py-2">Действие</th>
                </tr>
                </thead>
                <tbody>
                  {leads.data.map((lead) => (
                    <tr key={lead.id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                      <td className="px-3 py-2">{lead.id}</td>
                      <td className="px-3 py-2">{lead.name}</td>
                      <td className="px-3 py-2">{lead.created_at_local}</td>
                      <td className="px-3 py-2">
                        <span className={
                          "px-2 py-1 rounded text-white " +
                          SUCCESS_CLASS_MAP[lead.has_contact]
                        }>
                          { LEAD_HAS_CONTACT_TEXT_MAP[lead.has_contact] }
                        </span>
                      </td>
                      <td className="px-3 py-2">
                        <Link href={route('contact.create', lead.id)}
                              disabled={!!lead.has_contact}
                              as={lead.has_contact ? 'button' : undefined}
                        >
                          <span className={
                            "px-2 py-1 rounded text-white " +
                            (lead.has_contact ? "bg-gray-500" : "bg-green-500")
                          }>
                            Привязать контакт
                          </span>
                        </Link>
                      </td>
                    </tr>
                    ))}
                </tbody>
              </table>
              <Pagination links={leads.meta.links} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}
