import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head} from "@inertiajs/react";
import Pagination from "@/Components/Pagination.jsx";
import {SUCCESS_CLASS_MAP, RECORD_SUCCESS_TEXT_MAP} from "@/constants.js";

export default function Index({auth, historyRecords}) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800
        dark:text-gray-200 leading-tight">
          История
        </h2>
      }
    >
      <Head title="История"/>

      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div className="p-6 text-gray-900 dark:text-gray-100">

              <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700
                                  dark:text-gray-400 border-b-2 border-gray-500">
                  <tr className="text-nowrap">
                    <th className="px-3 py-2">Действие</th>
                    <th className="px-3 py-2">Результат</th>
                    <th className="px-3 py-2">Дата и время</th>
                  </tr>
                </thead>
                <tbody>
                { historyRecords.data.map((record) => (
                  <tr key={record.id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td className="px-3 py-2">{record.action}</td>
                    <td className="px-3 py-2">
                      <span className={
                        "px-2 py-1 rounded text-white " +
                        SUCCESS_CLASS_MAP[record.success]
                      }>
                        { RECORD_SUCCESS_TEXT_MAP[record.success] }
                      </span>
                    </td>
                    <td className="px-3 py-2">{record.created_at}</td>
                  </tr>
                )) }
                </tbody>
              </table>
              <Pagination links={historyRecords.meta.links} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}
